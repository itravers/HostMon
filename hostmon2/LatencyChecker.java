import java.util.ArrayList;
import java.util.Iterator;
import java.util.concurrent.PriorityBlockingQueue;

/**
 * Latency Checker is the Main Worker of the backend.
 * It will create a database connection getting an ArrayList of all
 * IP's that need to be checked. It will create a job for each ip. It will then start
 * passing jobs to it's thread pool to be executed.
 * Every time a job is executed it's results are written to the database, the average 
 * amount of time it took the job to be executed is calculated, if this average is
 * too high, another thread will be added to the thread pool.
 * @author admin
 *
 */
public class LatencyChecker {
	
	/**
	 * The Constructor
	 * @param db
	 */
	public LatencyChecker(DataBase db){
		this.db = db;
		Functions.debug("LatencyChecker LatencyChecker()");
		init();
		mainLoop();
	}
	
	/* Public Methods */
	
	/* Private Methods */
	
	/**
	 * Loops every x seconds, Checks Database for list of ip's that are
	 * currently supposed to be active. Marks any job not in list as inactive. 
	 * Then checks every job currently owned by a thread. It checks those jobs against
	 * the databases active list and marks the one's not present as inactive
	 * Every time a job is done processing it checks if it is active or not,
	 * if not the job get's removed from the queue.
	 * Any job that is not present in the queue or worker threads, but is present
	 * in the active list will be created and added to the queue.
	 */
	private void mainLoop(){
		//test();
		while(running){
			Functions.debug("LatencyChecker mainLoop()");
			//get a list of active ip's from the database
			ArrayList<String>activeIps = db.getActiveIps();
			ArrayList<RunnablePing>pingToRemove = new ArrayList<RunnablePing>();
			ArrayList<RunnablePing>activePings = new ArrayList<RunnablePing>();
			//loop through activeIP's compare them with ip's from runnables in queue, and pool
			for(int i = 0; i < activeIps.size(); i++){
				//go through queue and get all RunnablePings that math ActiveIP's
				Iterator queueIterator = queue.iterator();
				while(queueIterator.hasNext()){
					RunnablePing p = (RunnablePing) queueIterator.next();
					p.active = false;
					//queue.remove(p);
					if(p.getIp().equals(activeIps.get(i))){
						if(!activePings.contains(p)) {
							activePings.add(p);
						}
					}
				}
				
				//next we loop through the thread pool threads, get their runnablePing and check that
				for(int j = 0; j < pool.getThreads().size(); j++){
					RunnablePing p = (RunnablePing) pool.getThreads().get(j).getCurrentRunnable();
					if(p != null){
						p.active = false;
						if(p.active && p.getIp().equals(activeIps.get(i))){
							if(!activePings.contains(p)){
								activePings.add(p);
							}
						}
					}
				}
			}
			
			//next we loop through active pings and remove anything that doesn't have a activeIP
			for(int i = 0; i< activePings.size(); i++){
				boolean found = false;
				for(int j = 0; j < activeIps.size(); j++){
					if(activeIps.get(j).equals(activePings.get(i).getIp())){
						found = true;
					}
				}
				if(found){
					
					//boole
					if(!queue.contains(activePings.get(i))){
						queue.add(activePings.get(i));
						activePings.get(i).active = true;
					}
				}
			}
			
			//any activeIp's left should be new one's that need to
			//be added to the priority queue
			for(int i = 0; i < activeIps.size(); i++){
				RunnablePing p = new RunnablePing(activeIps.get(i), queue, db, tracker);
				boolean addIt = true;
				Iterator queueIterator = queue.iterator();
				while(queueIterator.hasNext()){
					RunnablePing p2 = (RunnablePing) queueIterator.next();
					if(p2.getIp().equals(p.getIp())){ //if the ip's equal, we don't add it again
						addIt = false;
					}
				}
				if(addIt) queue.add(p);
				//System.out.println("test");
			}
			
			try {
				Thread.sleep(10000);
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
	}
	
	private void test(){
		//create a new RunnablePing, add it to the queue
		pool.execute(new RunnablePing("google.com", queue, db, tracker));
		pool.execute(new RunnablePing("facebook.com", queue, db, tracker));
		pool.execute(new RunnablePing("reddit.com", queue, db, tracker));
		pool.execute(new RunnablePing("gmail.com", queue, db, tracker));
		pool.execute(new RunnablePing("digitalpath.com", queue, db, tracker));
		pool.execute(new RunnablePing("w3schools.com", queue, db, tracker));
		pool.execute(new RunnablePing("myspace.com", queue, db, tracker));
		pool.execute(new RunnablePing("hotmail.com", queue, db, tracker));
		pool.execute(new RunnablePing("youtube.com", queue, db, tracker));
		pool.execute(new RunnablePing("microsoft.com", queue, db, tracker));
		pool.execute(new RunnablePing("new.com", queue, db, tracker));
		pool.execute(new RunnablePing("new.net", queue, db, tracker));
		pool.execute(new RunnablePing("news.com", queue, db, tracker));
		pool.execute(new RunnablePing("news.net", queue, db, tracker));
		pool.execute(new RunnablePing("hello.com", queue, db, tracker));
		pool.execute(new RunnablePing("hello.org", queue, db, tracker));
		pool.execute(new RunnablePing("hello.net", queue, db, tracker));
		pool.execute(new RunnablePing("xnxx.com", queue, db, tracker));
		pool.execute(new RunnablePing("fightnight.com", queue, db, tracker));
		pool.execute(new RunnablePing("xhamster.com", queue, db, tracker));
		pool.execute(new RunnablePing("hbo.com", queue, db, tracker));
	}
	
	/**Initialize The Field Objects & Variables for the Class*/
	private void init() {
		Functions.debug("LatencyChecker init()");
		tracker = new Tracker();
		this.db = db;
		queue = new PriorityBlockingQueue();
		pool = new ThreadPool(queue, Functions.getStartingThreads(), tracker);
		running = true;
	}

	/* Field Objects & Variables */
	private DataBase db;
	private PriorityBlockingQueue queue;
	private ThreadPool pool;
	private boolean running;
	private Tracker tracker;
}

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
		test();
		//while(running){
			Functions.debug("LatencyChecker mainLoop()");
			
			
			try {
				Thread.sleep(1000);
			} catch (InterruptedException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		//}
	}
	
	private void test(){
		//create a new RunnablePing, add it to the queue
		pool.execute(new RunnablePing("google.com", queue));
		pool.execute(new RunnablePing("facebook.com", queue));
		pool.execute(new RunnablePing("reddit.com", queue));
		pool.execute(new RunnablePing("gmail.com", queue));
		pool.execute(new RunnablePing("digitalpath.com", queue));
		pool.execute(new RunnablePing("w3schools.com", queue));
		pool.execute(new RunnablePing("myspace.com", queue));
		pool.execute(new RunnablePing("hotmail.com", queue));
		pool.execute(new RunnablePing("youtube.com", queue));
		pool.execute(new RunnablePing("microsoft.com", queue));
		pool.execute(new RunnablePing("new.com", queue));
		pool.execute(new RunnablePing("new.net", queue));
		pool.execute(new RunnablePing("news.com", queue));
		pool.execute(new RunnablePing("news.net", queue));
		pool.execute(new RunnablePing("hello.com", queue));
		pool.execute(new RunnablePing("hello.org", queue));
		pool.execute(new RunnablePing("hello.net", queue));
		pool.execute(new RunnablePing("xnxx.com", queue));
		pool.execute(new RunnablePing("fightnight.com", queue));
		pool.execute(new RunnablePing("xhamster.com", queue));
		pool.execute(new RunnablePing("hbo.com", queue));
	}
	
	/**Initialize The Field Objects & Variables for the Class*/
	private void init() {
		Functions.debug("LatencyChecker init()");
		this.db = db;
		queue = new PriorityBlockingQueue();
		pool = new ThreadPool(queue, Functions.getStartingThreads());
		running = true;
	}

	/* Field Objects & Variables */
	private DataBase db;
	private PriorityBlockingQueue queue;
	private ThreadPool pool;
	private boolean running;
}

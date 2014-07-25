import java.util.concurrent.PriorityBlockingQueue;

/**
 * The Runnable object that pings an ip, decodes the ping, adds a record to the database
 * and checks
 * @author admin
 *
 */
public class RunnablePing  implements Comparable, Runnable{
	
	public RunnablePing(String ip, PriorityBlockingQueue<RunnablePing>queue, DataBase db){
		this.db = db;
		pinger = new Pinger();
		active = true;
		runTime = 0;
		timeCompletedLast = 0;
		this.ip = ip;
		this.queue	= queue;
	}

	@Override
	public void run() {
		long startTime = System.currentTimeMillis();
		System.out.println("ping " + ip + ":" + pinger.ping(ip));
		String latency = pinger.ping(ip);
		String timeStamp = Long.toString(System.currentTimeMillis());
		db.recordPing(ip, timeStamp, latency);
		
		
		//if timeCompletedLast is 0, this is first run and runtime is calculated from start
		if(timeCompletedLast == 0){
			runTime = System.currentTimeMillis() - startTime;
		}else{
			// else, we measure runtime from end to end
			//calculate runTime endToEnd
			runTime = System.currentTimeMillis() - timeCompletedLast;
		}
		timeCompletedLast = System.currentTimeMillis();
	}

	
	public int compareTo(Object o) {
		final int BEFORE = -1;
	    final int EQUAL = 0;
	    final int AFTER = 1;
	    int returnVal = 0;
		
	    RunnablePing p = (RunnablePing) o;
	    if(getTimeCompleted() < p.getTimeCompleted()){
	    	returnVal = BEFORE;
	    }else if(getTimeCompleted() > p.getTimeCompleted()){
	    	returnVal = AFTER;
	    }else{
	    	returnVal = EQUAL;
	    }
		return returnVal;
	}
	
	public long getTimeCompleted(){
		return timeCompletedLast;
	}
	
	public long getRunTime(){
		return runTime;
	}
	
	/* Field Objects & Variables */
	private long timeCompletedLast;
	private String ip;
    private PriorityBlockingQueue<RunnablePing> queue;
    private long runTime;
    public boolean active;
    private Pinger pinger;
    private DataBase db;
}

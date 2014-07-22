import java.util.concurrent.PriorityBlockingQueue;

/**
 * The Runnable object that pings an ip, decodes the ping, adds a record to the database
 * and checks
 * @author admin
 *
 */
public class RunnablePing  implements Comparable, Runnable{
	
	public RunnablePing(String ip, PriorityBlockingQueue<RunnablePing>queue){
		active = true;
		runTime = 0;
		timeCompletedLast = 0;
		this.ip = ip;
		this.queue	= queue;
	}

	@Override
	public void run() {
		long startTime = System.currentTimeMillis();
		// TODO Auto-generated method stub
		//Functions.debug("RunnablePing run() " + ip);
		try {
			Thread.sleep(1000);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
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
}

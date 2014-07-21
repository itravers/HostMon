import java.util.concurrent.PriorityBlockingQueue;


public class RunnablePing  implements Comparable, Runnable{
	
	public RunnablePing(String ip, PriorityBlockingQueue<RunnablePing>queue){
		this.ip = ip;
		this.queue	= queue;
	}

	@Override
	public void run() {
		// TODO Auto-generated method stub
		Functions.debug("RunnablePing run() " + ip);
		try {
			Thread.sleep(10000);
		} catch (InterruptedException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		timeCompletedLast = System.currentTimeMillis();
	}

	
	public int compareTo(Object o) {
		final int BEFORE = -1;
	    final int EQUAL = 0;
	    final int AFTER = 1;
	    int returnVal = 0;
		
	    RunnablePing p = (RunnablePing) o;
	    if(getTimeCompleted() > p.getTimeCompleted()){
	    	returnVal = BEFORE;
	    }else if(getTimeCompleted() < p.getTimeCompleted()){
	    	returnVal = AFTER;
	    }else{
	    	returnVal = EQUAL;
	    }
		return returnVal;
	}
	
	public long getTimeCompleted(){
		return timeCompletedLast;
	}
	
	/* Field Objects & Variables */
	private long timeCompletedLast;

	

	private String ip;
    private PriorityBlockingQueue<RunnablePing> queue;
}

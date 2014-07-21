import java.util.concurrent.PriorityBlockingQueue;


public class PingThread extends Thread{
	
	 

	  public PingThread(PriorityBlockingQueue<RunnablePing> queue){
	    this.queue = queue;
	    isStopped = false;
	  }

	  public void run(){
	    while(!isStopped){
	      try{
	        Runnable runnable = (Runnable) queue.take();
	        runnable.run();
	      } catch(Exception e){
	        //log or otherwise report exception,
	        //but keep pool thread alive.
	      }
	    }
	  }

	  public synchronized void stopThread(){
		stop();
	    isStopped = true;
	    this.interrupt(); //break pool thread out of dequeue() call.
	  }

	  public synchronized boolean isStopped(){
	    return isStopped;
	  }
	
	/* Field Objects & Variables */
	private PriorityBlockingQueue<RunnablePing> queue;
	private boolean isStopped;
	

}

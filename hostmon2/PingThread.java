
public class PingThread extends Thread implements Comparable{
	
	 private BlockingQueue taskQueue = null;
	  private boolean       isStopped = false;

	  public PoolThread(BlockingQueue queue){
	    taskQueue = queue;
	  }

	  public void run(){
	    while(!isStopped()){
	      try{
	        Runnable runnable = (Runnable) taskQueue.dequeue();
	        runnable.run();
	      } catch(Exception e){
	        //log or otherwise report exception,
	        //but keep pool thread alive.
	      }
	    }
	  }

	  public synchronized void stop(){
	    isStopped = true;
	    this.interrupt(); //break pool thread out of dequeue() call.
	  }

	  public synchronized void isStopped(){
	    return isStopped;
	  }

	@Override
	public int compareTo(Object arg0) {
		// TODO Auto-generated method stub
		return 0;
	}

}

import java.util.concurrent.PriorityBlockingQueue;

/**
 * This is a Thread in the Thread Pool. Each Thread will take a Runnable from
 * the queue and run it. After the thread runs, it will first find the amount of
 * time it took the runnable to complete, and add that to it's own total time.
 * It will track how many times it has run. It will give us an average time it
 * takes this thread to run a job. After it does this, it will check the
 * runnable to see if it is supposed to be run again, if so it will requeue it.
 * If not it will destroy it.
 * 
 * @author Isaac Assegai
 * 
 */
public class PingThread extends Thread {

	public PingThread(PriorityBlockingQueue<RunnablePing> queue) {
		totalRunTime = 0;
		numRuns = 0;
		this.queue = queue;
		isStopped = false;
	}

	public void run() {
		while (!isStopped) {
			try {
				RunnablePing runnable = (RunnablePing) queue.take();
				runnable.run();
				
				// update numRuns and totalRunTime counts;
				totalRunTime += ((RunnablePing)runnable).getRunTime();
				numRuns++;
				
				// check if runnable is still active, requeue if so, destroy if not
				if(((RunnablePing)runnable).active){
					queue.add(runnable);
				}else{
					//it'll get garbage collected by the jvm
				}
			} catch (Exception e) {
				System.out.println(e);
				// log or otherwise report exception,
				// but keep pool thread alive.
			}
			
			
		}
	}

	public synchronized void stopThread() {
		stop();
		isStopped = true;
		this.interrupt(); // break pool thread out of dequeue() call.
	}

	public synchronized boolean isStopped() {
		return isStopped;
	}
	
	public long getAverageRunTime(){
		return totalRunTime / numRuns;
	}
	
	public void resetAverageRunTime(){
		totalRunTime = 0;
		numRuns = 0;
	}

	/* Field Objects & Variables */
	private PriorityBlockingQueue<RunnablePing> queue;
	private boolean isStopped;
	private long totalRunTime;
	private int numRuns;

}

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

	public PingThread(ThreadPool p, PriorityBlockingQueue<RunnablePing> queue) {
		currentlyProcessing = false;
		parent = p;
		totalRunTime = 0;
		numRuns = 0;
		this.queue = queue;
		isStopped = false;
	}

	public void run() {
		while(true){
			while(isStopped){
				try {
					Thread.sleep(15);
				} catch (InterruptedException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			}
			while (!isStopped && !Thread.currentThread().isInterrupted()) {
				currentlyProcessing = true;
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
					
					//check once in a while to see if our PARENTS averageRunTime is getting
					//too much larger than our PARENTS goalAverageRunTime. If it is, and
					//we don't have too many threads already, then we can create another 
					//thread.
					
					//update PARENTS totalRuns, and averageRunTime
					int pRuns = parent.getTotalRuns();
					long pAverage = parent.getAverageRunTime();
					long myAverage = getAverageRunTime();
					long newPAverage =(pAverage + myAverage) / (2);
					
					parent.addRun();
					parent.setAverageRunTime(newPAverage);
					System.out.println("ThreadPoolTHREADS: " + parent.getThreads().size());
					System.out.println("ThreadPool - RUNS: " + parent.getTotalRuns());
					System.out.println("ThreadPool - TIME: " + parent.getAverageRunTime());
					//every 50 runs we will check if the parents average is meeting it's goals
					//if it is, we check by how much, if it's meeting it's goal by 2x then we get
					//rid of a thread. If it's not meeting it's goals we add a thread.
					if(parent.getTotalRuns() % 10 == 0){
						if(parent.getAverageRunTime() <= parent.getGoalRunTime()){
							if((parent.getAverageRunTime() + parent.getAverageRunTime()/3) <= parent.getGoalRunTime()){
								//average run time is less than half goal run time
								Functions.debug("Exceeded Timing Goal, removing thread.");
								parent.removeThread(this);
							}else{
								//we are hitting our timing goals, do nothing.
								Functions.debug("Hit Timing Goal.");
							}
						}else if((parent.getAverageRunTime() - parent.getAverageRunTime()/5) > parent.getGoalRunTime()){
							//if Average Run Time is 2x bigger than goal run time, we add a thread
							Functions.debug("Missed Timing Goal, adding Thread");
							parent.addThread();
						}else{
							//missed timing goal, but we are not bad enough to start another thread.
							Functions.debug("Missed Timing Goal.");
						}
						for (PingThread thread : parent.getThreads()) {
							thread.resetAverageRunTime();
						}
						//reset timers for parent, and me, and all brothers.
						totalRunTime = myAverage;
						parent.setAverageRunTime(myAverage);
						parent.setTotalRuns(1);
					}
				} catch (InterruptedException consumed) {
					System.out.println("THREAD INTERRUPTED");
					// log or otherwise report exception,
					// but keep pool thread alive.
				}
				//sleep for a second in currentlyProcessing = false mode
				//to allow the threadpool to catch it when it is not processing
				currentlyProcessing = false;
				try {
					Thread.sleep(10);
				} catch (InterruptedException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			}
		}
		
	}

	public synchronized void stopThread() {
		//stop();
		isStopped = true;
		//this.interrupt(); // break pool thread out of dequeue() call.
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
	private ThreadPool parent;
	private PriorityBlockingQueue<RunnablePing> queue;
	private boolean isStopped;
	private long totalRunTime;
	private int numRuns;
	public boolean currentlyProcessing;

}

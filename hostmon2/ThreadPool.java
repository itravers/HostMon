import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.PriorityBlockingQueue;

/**
 * Will keep track of threads, will accept new threads, will delete unneeded
 * threads
 * 
 * @author Isaac Assegai
 * 
 */
public class ThreadPool {

	/**
	 * Constructor
	 * @param noOfThreads
	 * @param maxNoOfTasks
	 */
	public ThreadPool(PriorityBlockingQueue<RunnablePing>queue, int noOfThreads) {
		this.noOfThreads = noOfThreads;
		this.queue = queue;
		averageRunTime = 0;
		totalRuns = 0;
		goalAverageRunTime = 2500;

		for (int i = 0; i < noOfThreads; i++) {
			threads.add(new PingThread(this, queue));
		}
		for (PingThread thread : threads) {
			thread.start();
		}
	}
	
	/* Public Methods. */
	
	public void addThread() {
		if(threads.size() < 10){
			PingThread thread;
			if(stoppedThreads.size() > 0){
				//there is a thread we can use in stoppedThreads
				thread = stoppedThreads.remove(0);
			}else{
				thread = new PingThread(this, queue);
				thread.start();
			}
			
			threads.add(thread);
			
		}
	}
	
	public void removeThread(PingThread thread){
		if(threads.size() > 1){
			threads.remove(thread);
			thread.stopThread();
			stoppedThreads.add(thread);
			
			
		}
	}

	/*
	 * Enqueue a Task a Thread will get to it.
	 */
	public synchronized void execute(Runnable task) {
		if (this.isStopped){
			throw new IllegalStateException("ThreadPool is stopped");
		}
		this.queue.add(task);
	}

	/**
	 * Stop All Threads
	 */
	public synchronized void stop() {
		this.isStopped = true;
		for (PingThread thread : threads) {
			thread.stop();
		}
	}
	
	public synchronized void setTotalRuns(int newRuns){
		totalRuns = newRuns;
	}
	
	public synchronized void setAverageRunTime(long newAvg){
		averageRunTime = newAvg;
	}
	
	public synchronized void addRun(){
		setTotalRuns(getTotalRuns()+1);
	}
	
	public synchronized int getTotalRuns(){
		return totalRuns;
	}
	
	public synchronized long getAverageRunTime(){
		return averageRunTime;
	}
	
	public synchronized long getGoalRunTime(){
		return goalAverageRunTime;
	}
	
	public synchronized ArrayList<PingThread> getThreads(){
		return (ArrayList<PingThread>) threads;
	}
	
	/* Private Methods */

	/* Field Objects & Variables */
	private PriorityBlockingQueue queue = null;
	private List<PingThread> threads = new ArrayList<PingThread>();
	private List<PingThread> stoppedThreads = new ArrayList<PingThread>();
	private boolean isStopped = false;
	private int noOfThreads;
	private long averageRunTime;
	private int totalRuns;
	public long goalAverageRunTime;
	
	

}

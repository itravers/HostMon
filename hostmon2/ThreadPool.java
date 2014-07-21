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
	public ThreadPool(int noOfThreads, int maxNoOfTasks) {
		queue = new PriorityBlockingQueue<PingThread>(maxNoOfTasks);

		for (int i = 0; i < noOfThreads; i++) {
			threads.add(new PingThread(queue));
		}
		for (PingThread thread : threads) {
			thread.start();
		}
	}
	
	/* Public Methods. */

	/*
	 * Enqueue a Task a Thread will get to it.
	 */
	public synchronized void execute(Runnable task) {
		if (this.isStopped){
			throw new IllegalStateException("ThreadPool is stopped");
		}
		this.queue.enqueue(task);
	}

	public synchronized void stop() {
		this.isStopped = true;
		for (PingThread thread : threads) {
			thread.stop();
		}
	}
	
	/* Private Methods */

	/* Field Objects & Variables */
	private PriorityBlockingQueue queue = null;
	private List<PingThread> threads = new ArrayList<PingThread>();
	private boolean isStopped = false;

}

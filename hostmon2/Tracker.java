/**
 * Runnable Ping Reports to Tracker everytime it runs.
 * Tracker keeps track of 
 * totalRuns, totalTime, currentRuns, currentTime
 * @author admin
 *
 */
public class Tracker {
	
	/** Constructor */
	public Tracker(){
		setTotalRuns(0);
		setTotalTime(0);
		setCurrentRuns(0);
		setCurrentTime(0);
	}
	
	public synchronized void addPing(long time){
		setTotalRuns(getTotalRuns()+1);
		setTotalTime(getTotalTime()+1);
		setCurrentRuns(getCurrentRuns()+1);
		setCurrentTime(getCurrentTime()+1);
	}
	
	public synchronized void resetCurrent(){
		setCurrentRuns(0);
		setCurrentTime(0);
	}

	
	/**
	 * @return the totalRuns
	 */
	public synchronized int getTotalRuns() {
		return totalRuns;
	}

	/**
	 * @param totalRuns the totalRuns to set
	 */
	public synchronized void setTotalRuns(int totalRuns) {
		this.totalRuns = totalRuns;
	}


	/**
	 * @return the totalTime
	 */
	public synchronized long getTotalTime() {
		return totalTime;
	}

	/**
	 * @param totalTime the totalTime to set
	 */
	public synchronized void setTotalTime(long totalTime) {
		this.totalTime = totalTime;
	}


	/**
	 * @return the currentRuns
	 */
	public synchronized int getCurrentRuns() {
		return currentRuns;
	}

	/**
	 * @param currentRuns the currentRuns to set
	 */
	public synchronized void setCurrentRuns(int currentRuns) {
		this.currentRuns = currentRuns;
	}


	/**
	 * @return the currentTime
	 */
	public synchronized long getCurrentTime() {
		return currentTime;
	}

	/**
	 * @param currentTime the currentTime to set
	 */
	public synchronized void setCurrentTime(long currentTime) {
		this.currentTime = currentTime;
	}
	
	public synchronized long getAverageTotalTime(){
		return getTotalTime()/getTotalRuns();
	}
	
	public synchronized long getAverageCurrentTime(){
		return getCurrentTime()/getCurrentRuns();
	}
	
	


	/* Field Variables and Objects */
	private int totalRuns;
	private long totalTime;
	private int currentRuns;
	private long currentTime;
}

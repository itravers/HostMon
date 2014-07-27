
public class Functions {
	public static void debug(String msg){
		boolean dbug = true;
		if(dbug){
			System.out.println(msg);
		}
	}
	
	public static long getAverageGoalTime(){
		return 15000;
	}

	public static int getStartingThreads() {
		return 1;
	}

	public static int getMaxThreads() {
		return 30;
	}

	/**
	 * The Value that decides when threads are removed. 
	 * The Lower the value the sooner an unneeded thread is removed.
	 * @return
	 */
	public static long getThreadRemovalCoeffient() {
		return 4;
	}

	/**
	 * The Value that decides when threads are added. 
	 * The Higher the value the sooner a needed thread is added.
	 * @return
	 */
	public static long getThreadAddCoeffient() {
		// TODO Auto-generated method stub
		return 10;
	}

	//every x amount of times a thread is run we check if we
	//need to add or remove a thread.
	public static int getRunPerThreadCheck() {
		// TODO Auto-generated method stub
		return 10;
	}

	/**
	 * The number of times we will ping before we make a call to the database.
	 * @return
	 */
	public static int getNumPingRunsBeforeDBRecord() {
		// TODO Auto-generated method stub
		return 10;
	}

	//the age each record in the minute table should get before being deleted. in millis
	public static long getMinuteRecordAgeLimit() {
		//15 minutes
		return 900000;
	}
	
	public static long getHourRecordAgeLimit() {
		return 14400000; //4 hours
	}

	
	public static long getDayRecordAgeLimit() {
		return 345600000; //shoud be 4 days
	}
	
	public static long getWeekRecordAgeLimit() {
		return 2419200000L; //shoud be 4 weeks
	}

	/*
	 * The amount of milliseconds we want to retrieve to average out new pings to add to hour table
	 * default was 5 minutes or 300000
	 */
	public static long getNewestPingMinutes() {
		return 300000;
	}
	
	/**
	 * The amount of milliseconds we want to retrieve in order to average out pings to add to the day table
	 * default is 1 hour or 3600000 millis
	 * @return
	 */
	public static long getNewestPingHours() {
		return 3600000;
	}
	
	/**
	 * The amount of milliseconds we want to retrieve in order to average out pings to add to the day table
	 * default is 1 day or 86400000 millis
	 * @return
	 */
	public static long getNewestPingDays() {
		return 86400000;
	}
	
	/**
	 * The amount of milliseconds we want to retrieve in order to average out pings to add to the day table
	 * default is 1 week or 604800000 millis
	 * @return
	 */
	public static long getNewestPingWeeks() {
		return 604800000;
	}

	

	
}

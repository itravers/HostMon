
public class Functions {
	public static void debug(String msg){
		boolean dbug = false;
		if(dbug){
			System.out.println(msg);
		}
	}
	
	public static long getAverageGoalTime(){
		return 15000;
	}

	public static int getStartingThreads() {
		return 15;
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
}

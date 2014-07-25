
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
		return 1;
	}

	public static int getMaxThreads() {
		return 20;
	}

	/**
	 * The Value that decides when threads are removed. 
	 * The Higher the value the sooner an unneeded thread is removed.
	 * @return
	 */
	public static long getThreadRemovalCoeffient() {
		return 3;
	}

	/**
	 * The Value that decides when threads are added. 
	 * The Higher the value the sooner a needed thread is added.
	 * @return
	 */
	public static long getThreadAddCoeffient() {
		// TODO Auto-generated method stub
		return 5;
	}
}

/**
 * Class used to aggregrate certain functions.
 * @author Isaac Assegai
 */
public class Functions {
	
	/**
	 * Print only if debug mode is true;
	 * @param msg The String to Print
	 */
	public static void debug(String msg){
		boolean dbug = true;
		if(dbug){
			System.out.println(msg);
		}
	}
}

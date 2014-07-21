import java.util.ArrayList;

/**
 * Class Responsible for all DataBase Connectivity.
 * @author Isaac Assegai
 *
 */
public class DataBase {
	
	/**
	 * Constructor
	 * @param options - Array List of options used for connecting and reading from db.
	 */
	public DataBase(ArrayList<String>options){
		this.options = options;
	}
	
	/* Public Methods*/
	
	/**
	 * Opens the db for reading or writing.
	 * @return True if db is now open. Else, False.
	 */
	public boolean open(){
		return false;
	}
	
	/**
	 * Lets us know if the db is currently open, or not.
	 * @return True if Open
	 */
	public boolean isOpen(){
		return false;
	}
	
	/**
	 * Closes the db.
	 * @return True if Closed.
	 */
	public boolean close(){
		return false;
	}
	
	/**
	 * Send a command to make a change in the database.
	 * @param dbCommand
	 * @return
	 */
	public boolean write(String dbCommand){
		return false;
	}
	
	/**
	 * Send a command to pull up information from the db.
	 * @param dbCommand
	 * @return
	 */
	public String read(String dbCommand){
		return null;
	}
	
	/* Private Methods */
	
	/* Static Methods */
	public static ArrayList<String> getDBOptions() {
		return null;
	}
	
	/* Field Objects and Variables */
	ArrayList<String>options;

	

	
}

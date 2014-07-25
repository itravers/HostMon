import java.util.ArrayList;
import java.sql.*;

/**
 * Class Responsible for all DataBase Connectivity.
 * @author Isaac Assegai
 *
 */
public class DataBase {
	
	public static void main(String[] args){
		DataBase db = new DataBase(getDBOptions());
		db.open();
		db.recordPing("192.168.1.1", "000000", "300");
		db.close();
		
		
		System.out.println("exit");
	}
	
	/**
	 * Constructor
	 * @param options - Array List of options used for connecting and reading from db.
	 */
	public DataBase(ArrayList<String>options){
		Functions.debug("DataBase DataBase()");
		this.options = options;
	}
	
	/* Public Methods*/
	
	/**
	 * Opens the db for reading or writing.
	 * @return True if db is now open. Else, False.
	 */
	public boolean open(){
		boolean returnVal = false;
		String dbName = options.get(0);
		String driver = "com.mysql.jdbc.Driver";
		String userName = options.get(1);
		String password = options.get(2);
		String url = "jdbc:mysql://"+options.get(3)+":3306/";
		
		try {
			Class.forName(driver).newInstance();
			conn = DriverManager.getConnection(url + dbName,
					userName, password);

			
		} catch (Exception e) {
			e.printStackTrace();
		}
		try {
			if(conn.isClosed()){
				returnVal = false;
			}else{
				returnVal = true;
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return returnVal;
	}
	
	/**
	 * Lets us know if the db is currently open, or not.
	 * @return True if Open
	 */
	public boolean isOpen(){
		Functions.debug("DataBase isOpen()");
		return false;
	}
	
	/**
	 * Closes the db.
	 * @return True if Closed.
	 */
	public boolean close(){
		try {
			conn.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return false;
	}
	
	/**
	 * Send a command to make a change in the database.
	 * @param dbCommand
	 * @return
	 */
	public boolean write(String dbCommand){
		Functions.debug("DataBase write()");
		return false;
	}
	
	/**
	 * Send a command to pull up information from the db.
	 * @param dbCommand
	 * @return
	 */
	public ResultSet read(String dbCommand){
		ResultSet res = null;
		try {
			this.open();
			Statement st;
			st = conn.createStatement();
			res = st.executeQuery(dbCommand);
			this.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return res;
	}
	
	public void recordPing(String ip, String timeStamp, String latency){
		String commandString = "INSERT into minute VALUES(default, '"+ip+"', '"+timeStamp+"','"+latency+"')";
		Statement st;
		int val = 0;
		try {
			st = conn.createStatement();
			val = st.executeUpdate(commandString);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		  if(val==1)
			  System.out.print("Successfully inserted value");

	}
	
	/* Private Methods */
	
	/* Static Methods */
	public static ArrayList<String> getDBOptions() {
		String o1="HostMon", o2="HostMonUser", o3="Micheal1", o4="192.168.2.146";
		ArrayList<String>dbOptions = new ArrayList<String>();
		dbOptions.add(o1);
		dbOptions.add(o2);
		dbOptions.add(o3);
		dbOptions.add(o4);
		return dbOptions;
	}
	
	/* Field Objects and Variables */
	ArrayList<String>options;
	static Connection conn;
}

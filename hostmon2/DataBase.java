import java.util.ArrayList;
import java.util.HashMap;
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
		db.recordPing("192.168.1.1", "000000", "301");
		db.recordPing("192.168.1.2", "000000", "302");
		db.recordPing("192.168.1.3", "000000", "303");
		db.recordPing("192.168.1.4", "000000", "304");
		db.recordPing("192.168.1.5", "000000", "305");
		db.recordPings();
		db.close();
		
		
		System.out.println("exit");
	}
	
	/**
	 * Constructor
	 * @param options - Array List of options used for connecting and reading from db.
	 */
	public DataBase(ArrayList<String>options){
		Functions.debug("DataBase DataBase()");
		pingRecord = new ArrayList<ArrayList<String>>();
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
	public synchronized int write(String dbCommand){
		int returnVal = 0;
		Statement st;
		try {
			this.open();
			st = conn.createStatement();
			returnVal = st.executeUpdate(dbCommand);
			this.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return returnVal;
	}
	
	/**
	 * Send a command to pull up information from the db.
	 * @param dbCommand
	 * @return
	 */
	public synchronized HashMap<String, String>read(String dbCommand){
		ResultSet res = null;
		HashMap<String,String>results = new HashMap<String,String>();
		String tableName = "";
		try {
			this.open();
			Statement st;
			st = conn.createStatement();
			res = st.executeQuery(dbCommand);
			while (res.next()) {
				tableName = res.getMetaData().getTableName(1);
				if(tableName.equals("timers")){
					results.put(res.getString("name"), res.getString("value"));
				}else if(tableName.equals("minute")){
					results.put("id", res.getString("id"));
					results.put("ip", res.getString("ip"));
					results.put("time", res.getString("time"));
					results.put("latency", res.getString("latency"));
				}
			}
			this.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return results;
	}
	
	/**
	 * Inserts a list of ping records.
	 */
	private synchronized void recordPings() {
		int val = 0;
		for (int i = 0; i < pingRecord.size(); i++) {
			String ip = pingRecord.get(i).get(0);
			String timeStamp = pingRecord.get(i).get(1);
			String latency = pingRecord.get(i).get(2);
			String commandString = "INSERT into minute VALUES(default, '" + ip
					+ "', '" + timeStamp + "','" + latency + "')";
			val = write(commandString);
		}
		if (val == 1) {
			System.out.print("Successfully inserted values");
		}
		pingRecord.clear();
	}
	
	public synchronized void recordPing(String ip, String timeStamp, String latency){
		ArrayList<String>list = new ArrayList<String>();
		list.add(ip);
		list.add(timeStamp);
		list.add(latency);
		pingRecord.add(list);
		
		//once there are x ping records, we want to record to database.
		if(pingRecord.size() >= Functions.getNumPingRunsBeforeDBRecord()){
			recordPings();
		}
	}
	
	public HashMap<String,String> getTimers() {
		// TODO Auto-generated method stub
		String command = "SELECT * FROM timers";
		return read(command);
	}
	
	public HashMap<String,String> getNewestFiveMinutesOfPings() {
		// TODO Auto-generated method stub
		long timeLimit = System.currentTimeMillis() - Functions.getNewestPingMinutes();
		String command = "SELECT * FROM `minute` WHERE time > " + (timeLimit);
		HashMap<String,String> newestFiveMinutesOfPings = read(command);
		return newestFiveMinutesOfPings;
	}
	
	public void deleteOldMinuteRecords() {
		
		// TODO Auto-generated method stub
		long ageLimit = Functions.getMinuteRecordAgeLimit();
		long time = System.currentTimeMillis();
		long oldTime = time-ageLimit;
		String command = "DELETE FROM `minute` WHERE time <="+oldTime;
		write(command);
		System.out.println("deleted Records older than " + ageLimit/1000 + " seconds");
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
	ArrayList<ArrayList<String>>pingRecord;
	
	
	
}

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map.Entry;
import java.util.Set;
import java.sql.*;

/**
 * This Class is an intermediary between the underlying database and the
 * rest of the program. As of now it supports MySQL.
 * Any information that needs to be written to or read from the database should use
 * this class .
 * @author Isaac Assegai
 */
public class DataBase {
	
	/**
	 * Entry Point used for testing Class
	 * @param args
	 */
	public static void main(String[] args){
		DataBase db = new DataBase(getDBOptions());
		String setting = db.getConfig("averageGoalTime");
		System.out.println("exit");
	}
	
	/**
	 * Constructor
	 * @param options - Array List of options used for connecting and reading from db.
	 */
	public DataBase(ArrayList<String>options){
		Functions.debug("DataBase DataBase()");
		pingRecord = new ArrayList<ArrayList<String>>();
		config = new HashMap<String, String>();
		this.options = options;
	}
	
	/* Public Methods*/
	/**
	 * Records a HashMap<String, <HashMap<String, String>>> of records into the hour table
	 * this hashmap has each record averaged
	 * @param averagedRecords
	 */
	public void recordHourRecords(
			HashMap<String, HashMap<String, String>> averagedRecords) {
		int val = 0;
		for (Entry<String, HashMap<String, String>> entry : averagedRecords.entrySet()) {
			String ip = entry.getKey();
			String timeStamp = entry.getValue().get("time");
			String latency = entry.getValue().get("latency");
			String commandString = "INSERT into hour VALUES(default, '" + ip
					+ "', '" + timeStamp + "','" + latency + "')";
			val = write(commandString);
		}
		if (val == 1) {
			System.out.print("Inserted Latest Pings Into Hour Table");
		}
	}
	
	/**
	 * Records a HashMap<String, <HashMap<String, String>>> of records into the day table
	 * this hashmap has each record averaged
	 * @param averagedRecords
	 */
	public void recordDayRecords(
			HashMap<String, HashMap<String, String>> averagedRecords) {
		int val = 0;
		for (Entry<String, HashMap<String, String>> entry : averagedRecords.entrySet()) {
			String ip = entry.getKey();
			String timeStamp = entry.getValue().get("time");
			String latency = entry.getValue().get("latency");
			String commandString = "INSERT into day VALUES(default, '" + ip
					+ "', '" + timeStamp + "','" + latency + "')";
			val = write(commandString);
		}
		if (val == 1) {
			System.out.print("Inserted Latest Pings Into Day Table");
		}
	}
	
	/**
	 * Records a HashMap<String, <HashMap<String, String>>> of records into the week table
	 * this hashmap has each record averaged
	 * @param averagedRecords
	 */
	public void recordWeekRecords(
			HashMap<String, HashMap<String, String>> averagedRecords) {
		int val = 0;
		for (Entry<String, HashMap<String, String>> entry : averagedRecords.entrySet()) {
			String ip = entry.getKey();
			String timeStamp = entry.getValue().get("time");
			String latency = entry.getValue().get("latency");
			String commandString = "INSERT into week VALUES(default, '" + ip
					+ "', '" + timeStamp + "','" + latency + "')";
			val = write(commandString);
		}
		if (val == 1) {
			System.out.print("Inserted Latest Pings Into Week Table");
		}
	}
	
	/**
	 * Records a HashMap<String, <HashMap<String, String>>> of records into the year table
	 * this hashmap has each record averaged
	 * @param averagedRecords
	 */
	public void recordYearRecords(
			HashMap<String, HashMap<String, String>> averagedRecords) {
		int val = 0;
		for (Entry<String, HashMap<String, String>> entry : averagedRecords.entrySet()) {
			String ip = entry.getKey();
			String timeStamp = entry.getValue().get("time");
			String latency = entry.getValue().get("latency");
			String commandString = "INSERT into year VALUES(default, '" + ip
					+ "', '" + timeStamp + "','" + latency + "')";
			val = write(commandString);
		}
		if (val == 1) {
			System.out.print("Inserted Latest Pings Into Year Table");
		}
	}
	
	/**
	 * Responsible for recording latency into the database. This object will keep a record
	 * of pings. Every X times this method is called the record of pings will be
	 * recorded to the database
	 * @param ip The ip of the device we are recording.
	 * @param timeStamp The time that this ping happened.
	 * @param latency The result of the ping.
	 */
	public synchronized void recordPing(String ip, String timeStamp, String latency){
		ArrayList<String>list = new ArrayList<String>();
		list.add(ip);
		list.add(timeStamp);
		list.add(latency);
		pingRecord.add(list);
		
		//once there are x ping records, we want to record to database. 
		if(pingRecord.size() >= Integer.parseInt(getConfig("numPingRunsBeforeDBRecord"))){
			recordPings();
		}
	}
	
	/**
	 * Returns a list of timers from the db, in our "special" format.
	 * @return
	 */
	public ArrayList<HashMap<String, String>> getTimers() {
		ArrayList<HashMap<String, String>> result = new ArrayList<HashMap<String, String>>();

		// we need to read from db
		String command = "SELECT * FROM timers";
		result = read(command);
		return result;
	}
	
	/**
	 * Updates a timer in the database. Useful if the program stops running it
	 * will still be able to maintain the db on the next run at the appropriate
	 * times.
	 * @param timerName The Name of the Timer
	 * @param newTime The next time the Timer should be set off
	 */
	public void setTimer(String timerName, String newTime){
		int val = 0;
		
		String commandString = "UPDATE timers SET timers.value='"+newTime+"' WHERE timers.name='"+timerName+"' ; ";
		val = write(commandString);
		
		if (val == 1) {
			System.out.print("Updated timer: " + timerName);
		}
	}
	
	/**
	 * Returns the newest 5 minutes of records in the minute table.
	 * @return The information requested in our "Special" format.
	 */
	public ArrayList<HashMap<String, String>> getNewestFiveMinutesOfPings() {
		long timeLimit = System.currentTimeMillis() - Long.parseLong(getConfig("newestPingMinutes"));
		String command = "SELECT * FROM `minute` WHERE time > " + (timeLimit);
		ArrayList<HashMap<String, String>> newestFiveMinutesOfPings = read(command);
		return newestFiveMinutesOfPings;
	}
	
	/**
	 * Returns the newest hour of records in the hour table.
	 * @return The information requested in our "Special" format.
	 */
	public ArrayList<HashMap<String, String>> getNewestHourOfPings() {
		long timeLimit = System.currentTimeMillis() - Long.parseLong(getConfig("newestPingHours"));
		String command = "SELECT * FROM `hour` WHERE time > " + (timeLimit);
		ArrayList<HashMap<String, String>> newestHourOfPings = read(command);
		return newestHourOfPings;
	}
	
	/**
	 * Returns the newest day of records in the day table.
	 * @return The information requested in our "Special" format.
	 */
	public ArrayList<HashMap<String, String>> getNewestDayOfPings() {
		long timeLimit = System.currentTimeMillis() - Long.parseLong(getConfig("newestPingDays"));
		String command = "SELECT * FROM `day` WHERE time > " + (timeLimit);
		ArrayList<HashMap<String, String>> newestDayOfPings = read(command);
		return newestDayOfPings;
	}
	
	/**
	 * Returns the newest week of records in the week table.
	 * @return The information requested in our "Special" format.
	 */
	public ArrayList<HashMap<String, String>> getNewestWeekOfPings() {
		long timeLimit = System.currentTimeMillis() - Long.parseLong(getConfig("newestPingWeeks"));
		String command = "SELECT * FROM `week` WHERE time > " + (timeLimit);
		ArrayList<HashMap<String, String>> newestWeekOfPings = read(command);
		return newestWeekOfPings;
	}
	
	/**
	 * Returns a list of active devices ID, in our "special" format.
	 * @return The ID's of our active devices, in our "special" format.
	 */
	public ArrayList<HashMap<String, String>> getActivePings() {
		String command = "SELECT * FROM `Active_Devices`";
		ArrayList<HashMap<String, String>> activePings = read(command);
		return activePings;
	}
	
	/**
	 * Returns an array list of ip addresses that represent active devices
	 * that are currently supposed to be pinged.
	 * @return The ArrayList of IP's
	 */
	public ArrayList<String> getActiveIps(){
		ArrayList<HashMap<String, String>> activePings = getActivePings();
		ArrayList<String>newActiveIPs = new ArrayList<String>();
		for(int i = 0; i < activePings.size(); i++){
			String command = "SELECT * FROM `Devices` WHERE Devices.id="+activePings.get(i).get("id")+"";
			ArrayList<HashMap<String, String>> activeIPs = read(command);
			newActiveIPs.add(activeIPs.get(0).get("ip"));
		}
		return newActiveIPs;
	}
	
	/**
	 * Deletes Records in the minute table that are older that
	 * a predetermined age limit.
	 */
	public void deleteOldMinuteRecords() {
		long ageLimit = Long.parseLong(getConfig("minuteRecordAgeLimit"));
		long time = System.currentTimeMillis();
		long oldTime = time-ageLimit;
		String command = "DELETE FROM `minute` WHERE time <="+oldTime;
		write(command);
		System.out.println("deleted Records older than " + ageLimit/1000 + " seconds");
	}
	
	/**
	 * Deletes Records in the hour table that are older that
	 * a predetermined age limit.
	 */
	public void deleteOldHourRecords() {
		long ageLimit = Long.parseLong(getConfig("hourRecordAgeLimit"));
		long time = System.currentTimeMillis();
		long oldTime = time-ageLimit;
		String command = "DELETE FROM `hour` WHERE time <="+oldTime;
		write(command);
		System.out.println("deleted Records older than " + ageLimit/1000 + " seconds");
	}
	
	/**
	 * Deletes Records in the day table that are older that
	 * a predetermined age limit.
	 */
	public void deleteOldDayRecords() {
		long ageLimit = Long.parseLong(getConfig("dayRecordAgeLimit"));
		long time = System.currentTimeMillis();
		long oldTime = time-ageLimit;
		String command = "DELETE FROM `day` WHERE time <="+oldTime;
		write(command);
		System.out.println("deleted Records older than " + ageLimit/1000 + " seconds");
	}
	
	/**
	 * Deletes Records in the week table that are older that
	 * a predetermined age limit.
	 */
	public void deleteOldWeekRecords() {
		long ageLimit = Long.parseLong(getConfig("weekRecordAgeLimit"));
		long time = System.currentTimeMillis();
		long oldTime = time-ageLimit;
		String command = "DELETE FROM `week` WHERE time <="+oldTime;
		write(command);
		System.out.println("deleted Records older than " + ageLimit/1000 + " seconds");
	}
	
	/**
	 * Gets a configuration settings, every few times it's run it will
	 * get new config settings from the database.
	 * @param name The name of the configuration setting.
	 * @return The value of the configuration setting.
	 */
	public String getConfig(String name){
		configReads++;
		if(configReads % 50 == 0 || configReads == 0 || !config.containsKey(name)){
			//pull config settings from database and add all to config
			config = getConfigsFromDB();
		}
		return config.get(name);
	}
	
	/**
	 * Gets all config settings from database.
	 * @return A Hashmap of the settings.
	 */
	public HashMap<String, String>getConfigsFromDB(){
		HashMap<String, String> returnVal = new HashMap<String, String>();
		String command = "SELECT * FROM configuration";
		ArrayList<HashMap<String,String>>dbResults = read(command);
		//loop through dbResults, pulling each item 0 and adding it's values to returnVal
		for(int i = 0; i < dbResults.size(); i++){
			HashMap<String, String>r = dbResults.get(i);
			Set<String> s = r.keySet();
			Iterator<String> iterator = s.iterator();
			while(iterator.hasNext()){
				String key = iterator.next();
				returnVal.put(key, r.get(key));
			}
		}
		return returnVal;
	}
	
	/* Private Methods */
	/**
	 * Opens the db for reading or writing.
	 * @return True if db is now open. Else, False.
	 */
	private boolean open(){
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
	 * Closes the db.
	 * @return True if Closed.
	 */
	private boolean close(){
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
	private synchronized int write(String dbCommand){
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
	private synchronized ArrayList<HashMap<String,String>>read(String dbCommand){
		ResultSet res = null;
		ArrayList<HashMap<String,String>>results = new ArrayList<HashMap<String,String>>();
		String tableName = "";
		try {
			this.open();
			Statement st;
			st = conn.createStatement();
			res = st.executeQuery(dbCommand);
			while (res.next()) {
				//System.out.println(res.getRow());
				HashMap<String,String>immediateResults = new HashMap<String,String>();
				tableName = res.getMetaData().getTableName(1);
				if(tableName.equals("timers")){
					immediateResults.put(res.getString("name"), res.getString("value"));
				}else if(tableName.equals("minute") || tableName.equals("hour") || tableName.equals("day") || tableName.equals("week")){
					immediateResults.put("id", res.getString("id"));
					immediateResults.put("ip", res.getString("ip"));
					immediateResults.put("time", res.getString("time"));
					immediateResults.put("latency", res.getString("latency"));
				}else if(tableName.equals("Active_Devices")){
					immediateResults.put("id", res.getString("deviceid"));;
				}else if(tableName.equals("Devices")){
					immediateResults.put("id", res.getString("id"));;
					immediateResults.put("ip", res.getString("ip"));;
					immediateResults.put("name", res.getString("name"));;
					immediateResults.put("description", res.getString("description"));;
				}else if(tableName.equals("configuration")){
					immediateResults.put(res.getString("name"), res.getString("value"));
				}
				if(results==null){
					System.out.println("null");
				}
				results.add(immediateResults);
			}
			//System.out.println(res.getRow());
			this.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return results;
	}
	
	/**
	 * Inserts a list of ping records into the DB
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
			System.out.println("Inserted Latest Pings Into Minute Table");
		}
		pingRecord.clear();
	}
	
	/* Static Methods */
	
	/**
	 * Reads from config file to find Database settings, or uses default if config
	 * file is not found. This config file should be generated by the front-end, or
	 * and install script.
	 * @return The ArrayList<String> of database name, user, password, ip
	 */
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
	
	/**The List of Options used to connect to the Database backend. */
	private ArrayList<String>options;
	/**The variable used to connect to the database*/
	private static Connection conn;
	/**The record of pings that have not yet been recorded to the database. */
	private ArrayList<ArrayList<String>>pingRecord;
	/**Used to decide when we want to pull new configuration data down from the DB.*/
	private int configReads = -1;
	/**Configuration Data that has been read in from the DB.*/
	private HashMap<String, String>config;
}

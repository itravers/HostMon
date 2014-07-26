import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map.Entry;

/**
 * Class used to perform the periodic maintenence on the database the app requires.
 * @author Isaac Assegai
 *
 */
public class DBMaintainer extends Thread{
	
	public static void main(String[] args){
		DataBase db = new DataBase(DataBase.getDBOptions());
		DBMaintainer dbMaintainer = new DBMaintainer(db);
		
	}
	
	public void run() {
		long minuteTimer = 0;
		ArrayList<HashMap<String, String>> timers = db.getTimers();
		try {
			long fiveMinuteTimer = Long.decode(timers.get(0).get("fiveMinuteTimer"));
			long fifteenMinuteTimer = Long.decode(timers.get(1).get("fifteenMinuteTimer"));
			long hourTimer = Long.decode(timers.get(2).get("hourTimer"));
			long twelveHourTimer = Long.decode(timers.get(3).get("twelveHourTimer"));
			long dayTimer = Long.decode(timers.get(4).get("dayTimer"));
			long fourtyEightHourTimer = Long.decode(timers.get(5).get("fourtyEightHourTimer"));
			long weekTimer = Long.decode(timers.get(6).get("weekTimer"));
			
			while(isRunning){
				if(System.currentTimeMillis() >= minuteTimer){
					//run every minute code & reset minute timer
					//get records older that 20 or x minutes, and delete them
					db.deleteOldMinuteRecords();
					minuteTimer = System.currentTimeMillis() + 60000;
				}
				
				if(System.currentTimeMillis() >= fiveMinuteTimer){
					//average the latest 5 minutes of data, for each device & reset minute timer
					ArrayList<HashMap<String, String>> newestFiveMinutesOfPings = db.getNewestFiveMinutesOfPings();
					HashMap<String, HashMap<String,ArrayList<String>>> hourRecords = new HashMap<String, HashMap<String, ArrayList<String>>>();
					for(int i = 0; i < newestFiveMinutesOfPings.size(); i++){
						String ip = newestFiveMinutesOfPings.get(i).get("ip");
						String time = newestFiveMinutesOfPings.get(i).get("time");
						String latency = newestFiveMinutesOfPings.get(i).get("latency");
						//if the hourRecords don't have the ip, we need to add a new record
						if(!hourRecords.containsKey(ip)){
							HashMap<String, ArrayList<String>> newRecord = new HashMap<String, ArrayList<String>>();
							//create new list for times and add the first one in
							ArrayList<String> timeList = new ArrayList<String>();
							timeList.add(time);
							newRecord.put("time", timeList);
							//create a new list for latencies, and add the first
							ArrayList<String> latencyList = new ArrayList<String>();
							latencyList.add(latency);
							newRecord.put("latency", latencyList);
							//add the time and latency to the ip label in the hourRecords
							hourRecords.put(ip, newRecord);
						}else{
							//hourRecords already contains a record for ip. We need to
							//add time and latency to their respective lists.
							HashMap<String, ArrayList<String>> modifyRecord = hourRecords.get(ip);
							//add the current time to timeList
							ArrayList<String>timeList = modifyRecord.get("time");
							timeList.add(time);
							//add the current latency to the latencyList
							ArrayList<String>latencyList = modifyRecord.get("latency");
							latencyList.add(latency);
						}
					}
					// now we are going to average out each list in hourRecords,
					// to get Rid of the list
					HashMap<String, HashMap<String, String>> averagedRecords = new HashMap<String, HashMap<String, String>>();
					for (Entry<String, HashMap<String, ArrayList<String>>> entry : hourRecords.entrySet()) {
						//System.out.printf("Key : %s and Value: %s %n", entry.getKey(), entry.getValue());
						String ip = entry.getKey();
						//average out times
						ArrayList<String>time = entry.getValue().get("time");
						long avgTime = 0;
						for(int i = 0; i < time.size(); i++){
							avgTime += Long.valueOf(time.get(i));
						}
						if(time.size() > 0)avgTime = avgTime / time.size();
						
						//average out latencies
						ArrayList<String>latency = entry.getValue().get("latency");
						long avgLatency = 0;
						for(int i = 0; i < latency.size(); i++){
							avgLatency += Long.valueOf(latency.get(i));
						}
						if(latency.size() > 0)avgLatency = avgLatency / latency.size();
						
						//add averaged record for this ip to averagedRecords
						HashMap<String, String> avgRecord = new HashMap<String, String>();
						avgRecord.put("time", String.valueOf(avgTime));
						avgRecord.put("latency", String.valueOf(avgLatency));
						averagedRecords.put(ip, avgRecord);
					}
					db.recordHourRecords(averagedRecords);
					System.out.println("stop here");
				}
				
				/*
				if(System.currentTimeMillis() >= fifteenMinuteTimer){
					//run every minute code & reset minute timer
				}
				
				if(System.currentTimeMillis() >= hourTimer){
					//run every minute code & reset minute timer
				}
				
				if(System.currentTimeMillis() >= twelveHourTimer){
					//run every minute code & reset minute timer
				}
				
				if(System.currentTimeMillis() >= dayTimer){
					//run every minute code & reset minute timer
				}
				
				if(System.currentTimeMillis() >= fourtyEightHourTimer){
					//run every minute code & reset minute timer
				}
				
				if(System.currentTimeMillis() >= weekTimer){
					//run every minute code & reset minute timer
				}*/
				
				try {
					Thread.sleep(1000);
				} catch (InterruptedException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				
			}
		} catch (NumberFormatException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}
		
		
		
	}
	
	public DBMaintainer(DataBase db) {
		isRunning = true;
		this.db = db;
		Functions.debug("DBMaintainer DBMaintainer()");
		start();
		
	}
	
	/* Public Methods */
	
	/* Private Methods */
	
	/* Field Objects & Variables */
	private boolean isRunning;
	private DataBase db;
}

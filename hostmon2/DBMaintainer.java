import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.HashMap;

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
		HashMap<String,String> timers = db.getTimers();
		try {
			long fiveMinuteTimer = Long.decode(timers.get("fiveMinuteTimer"));
			long fifteenMinuteTimer = Long.decode(timers.get("fifteenMinuteTimer"));
			long hourTimer = Long.decode(timers.get("hourTimer"));
			long twelveHourTimer = Long.decode(timers.get("twelveHourTimer"));
			long dayTimer = Long.decode(timers.get("dayTimer"));
			long fourtyEightHourTimer = Long.decode(timers.get("fourtyEightHourTimer"));
			long weekTimer = Long.decode(timers.get("weekTimer"));
			
			while(isRunning){
				if(System.currentTimeMillis() >= minuteTimer){
					//run every minute code & reset minute timer
					//get records older that 20 or x minutes, and delete them
					db.deleteOldMinuteRecords();
					minuteTimer = System.currentTimeMillis() + 60000;
				}
				
				if(System.currentTimeMillis() >= fiveMinuteTimer){
					//run every minute code & reset minute timer
					
					HashMap<String,String> newestFiveMinutesOfPings = db.getNewestFiveMinutesOfPings();
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

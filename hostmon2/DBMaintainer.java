import java.sql.ResultSet;
import java.util.ArrayList;

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
		/*
		long fiveMinuteTimer = db.getTimer("fiveMinute");
		long fifteenMinuteTimer = db.getTimer("fifteenMinute");
		long hourTimer = db.getTimer("hour");
		long twelveHourTimer = db.getTimer("twelveHour");
		long dayTimer = db.getTimer("day");
		long fourtyEightHourTimer = db.getTimer("fourtyEightHour");
		long weekTimer = db.getTimer("week");*/
		
		while(isRunning){
			if(System.currentTimeMillis() >= minuteTimer){
				//run every minute code & reset minute timer
				//get records older that 20 or x minutes, and delete them
				db.deleteOldMinuteRecords();
				minuteTimer = System.currentTimeMillis() + 60000;
			}
			/*
			if(System.currentTimeMillis() >= fiveMinuteTimer){
				//run every minute code & reset minute timer
			}
			
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

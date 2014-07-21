import java.util.ArrayList;

/**
 * Java Back-End of the HostMon Project.
 * This program will retrieve a list of ips to ping from a database.
 * It will then implement a strategy to ping each ip within an allotted time.
 * @author Isaac Assegai
 *
 */
public class Hostmon {

	/**
	 * The Program Start
	 */
	public static void main(String[] args) {
		Functions.debug("Hostmon main()");
		// TODO Auto-generated method stub
		Hostmon hostmon = new Hostmon();
	}
	
	/**
	 * The Constructor.
	 */
	public Hostmon(){
		Functions.debug("Hostmon Hostmon()");
		//Initialize Field Objects & Variables
		init(); 
	}
	
	/*
	 * Public Methods
	 */
	
	/*
	 * Private Methods
	 */
	
	private void init(){
		Functions.debug("Hostmon init()");
		//Retrieve the database connection options.
		ArrayList <String> dbOptions = DataBase.getDBOptions();
				
		//Instantiate the database object we will use to talk to the db.
		db = new DataBase(dbOptions);
		
		//Instantiate the class that will be responsible for maintaining the db.
		dbMaintainer = new DBMaintainer(db);
		
		lChecker = new LatencyChecker(db);
	}
	
	/*
	 * Field Objects & Variables
	 */
	
	/** The DataBase Object */
	private DataBase db;
	
	/** The DataBase Maintainer */
	private DBMaintainer dbMaintainer;
	
	/** The Main Latency Checker */
	private LatencyChecker lChecker;
}

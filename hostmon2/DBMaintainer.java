/**
 * Class used to perform the periodic maintenence on the database the app requires.
 * @author Isaac Assegai
 *
 */
public class DBMaintainer {
	
	public DBMaintainer(DataBase db){
		Functions.debug("DBMaintainer DBMaintainer()");
		this.db = db;
	}
	
	/* Public Methods */
	
	/* Private Methods */
	
	/* Field Objects & Variables */
	DataBase db;
}

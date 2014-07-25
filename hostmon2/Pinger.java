//to send to linux, commit, and push to remote.
//then go to /home/slack/hostmon and git pull origin
//to send to windows, commit, and push to remote.
//go to team, fetch from remote
import java.io.*;
 
public class Pinger {
	
	public Pinger(){
		
	}
 
    public static void main(String args[]) {

      //  System.out.println("writen on linux1 ");
        Pinger p = new Pinger();
	String cmdOutput = p.ping("google.com");
        //System.out.println("Output: " + cmdOutput);
    }

	public String ping(String ip) {
		String pingCommand = getPingCommand(ip);
		String pingResult = null;
		 try{
			 Runtime r = Runtime.getRuntime();
			 Process p = r.exec(pingCommand);

			 BufferedReader in = new BufferedReader(new InputStreamReader(p.getInputStream()));
			 String inputLine;
			 while ((inputLine = in.readLine()) != null) {
			     //System.out.println(inputLine);
			     pingResult += inputLine;
			 }
			 in.close();
			 pingResult = pingResult.toLowerCase();
			if(pingResult.contains("request timed out") || pingResult.contains("could not")
			 ||pingResult.contains("100% packet loss")){
				//don't know if request timed out is correct form in linux
				return "-1";
			}
		    pingResult = pingResult.substring(pingResult.indexOf("time=")+5, pingResult.length()-1);
		    pingResult = pingResult.substring(0, pingResult.indexOf("ms"));
		 	} catch(Exception e) {
		       System.out.println(e);
		    }
		 return pingResult;
	}

	private static String getPingCommand(String ip) {
		// TODO Auto-generated method stub
		String pingCommand = null;
		String os = System.getProperty("os.name");
		
		os = os.toLowerCase();
		if(os.contains("windows")){
			pingCommand = "ping " + ip + " -n 1";
		}else if(os.contains("linux")){
			pingCommand = "ping " + ip + " -c 1";
		}
		//System.out.println(os);
		return pingCommand;
	}
}

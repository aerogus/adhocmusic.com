package modele;

import java.sql.Connection;

public class Model implements InterfaceModele{
	public Connection co_;

	public Model()
	{
		co_ = Connector.openConnection("root","gillou91");
	}
	
	public Model(String url, String user, String mdp)
	{
		co_ = Connector.openConnection(user, mdp);
	}
	
	public boolean insert_adh(String first_name, String last_name, String postal, String age, String email)
	{
		String req = "INSERT INTO adherent (firstname, lastname, postal, year, age, email)"
					+"VALUES ('"+ first_name +"','"+ last_name +"','"+ postal +"','2012/2013', '"+ age +"', '"+ email +"');";
		int nb = Connector.insertBD(req);
		if(nb > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
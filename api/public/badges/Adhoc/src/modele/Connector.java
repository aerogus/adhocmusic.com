package modele;

import java.sql.*;

import com.mysql.jdbc.Connection;
import com.mysql.jdbc.Statement;

public class Connector implements InterfaceModele{
	//L'url est l'url de connexion
	public static String url_="jdbc:mysql://localhost:3306/Adhoc";
	public static Connection co_;

	public static Connection openConnection (String user, String mdp) {
		co_ = null;
		try {
			try {
				Class.forName("com.mysql.jdbc.Driver").newInstance();
			} catch ( IllegalAccessException e) {
				e.printStackTrace();
			} catch (InstantiationException e) {
				e.printStackTrace();
			}
			co_ = (Connection) DriverManager.getConnection(url_,user,mdp);
		}
		catch (ClassNotFoundException e){
			System.out.println("il manque le driver mysql");
			System.exit(1);
		}
		catch (SQLException e) {
			System.out.println("impossible de se connecter à l'url : "+url_);
			System.exit(2);
		}
		return co_;
	}

	public static int insertBD(String requete){
		Statement st = null;
		try {
			st = (Statement) co_.createStatement();
		} catch (SQLException e1) {
			// TODO Auto-generated catch block
			e1.printStackTrace();
		}

		int nb = 0;
		try {
			nb = st.executeUpdate(requete);
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			//e.printStackTrace();
			//System.out.println("fail ajout");
		}
		System.out.println(nb + " ligne(s) insérée(s)");
		try {
			st.close();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			//e.printStackTrace();
		}
		return nb;
	}

	//le string est la requete à effectuer, la Connection est la référence vers la connexion ouverte,
	//le type permet de choisir la manière de créer le Statement
	public static ResultSet execRequete (String requete, Connection co){
		ResultSet rs=null;
		try {
			Statement st=(Statement) co.createStatement();
			rs=st.executeQuery(requete);
		} catch (SQLException exRSMD) {
			exRSMD.printStackTrace();
		}

		return rs;
	}

	// la Connection est la référence vers la connexion ouverte
	public static void closeConnection(Connection co){
		try {
			co.close();
			System.out.println("Connexion fermée!");
		}
		catch (SQLException e) {
			System.out.println("Impossible de fermer la conenxion");
		}
	}
}
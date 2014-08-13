package base;


import view.View;
import controleur.Controleur;
import modele.Model;

public class Adhoc {
	private Model _model;
	private View _view;
	@SuppressWarnings("unused")
	private Controleur _controler;
	
	public Adhoc()
	{
		_model = new Model();
		_view = new View(_model);
		_controler = new Controleur(_model, _view);
	}
	
	
	public static void main(String[] args)
	{
			new Adhoc();
	}
}

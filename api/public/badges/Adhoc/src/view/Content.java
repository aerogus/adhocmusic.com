package view;

import java.awt.BorderLayout;

import javax.swing.JFrame;
import javax.swing.JPanel;

import modele.Model;

public class Content extends JFrame implements InterfaceVue{

	private static final long serialVersionUID = 1L;
	private Formulaire _form;

	public Formulaire get_form() {
		return _form;
	}

	public void set_form(Formulaire _form) {
		this._form = _form;
	}

	Content(Model model)
	{
		super();
		setDefaultCloseOperation(EXIT_ON_CLOSE);
		this.setTitle("Ad'Hoc Adhérent");
		BorderLayout bl = new BorderLayout();
		JPanel panel = new JPanel();
		panel.setLayout(bl);
		_form = new Formulaire();

		panel.add(_form, BorderLayout.NORTH);
		panel.add(new VueImage("logo_adhoc.png"), BorderLayout.CENTER);
		this.add(panel);
	}
	
}

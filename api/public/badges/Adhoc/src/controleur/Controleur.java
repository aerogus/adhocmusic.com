package controleur;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JOptionPane;
import javax.swing.JTextField;

import view.View;
import modele.Model;

public class Controleur implements ActionListener, InterfaceControleur{
	private View _view;
	private Model _model;
	private JButton _jb_validate;
	private JButton _jb_erase;
	private JTextField _jtf_first_name;
	private JTextField _jtf_last_name;
	private JTextField _jtf_postal;
	private JTextField _jtf_age;
	private JTextField _jtf_mail;
	private ImageIcon _img;
	/*private JOptionPane win;
	private JOptionPane fail;
	*/
	public Controleur(Model model, View view)
	{
		_model = model;
		_view = view;
		init();
	}
	
	public void init()
	{
		_img = new ImageIcon("logo_adhoc_icon.png");
		
		/*On récupère dans des variables locales les textfields et buttons.*/
		_jb_validate = _view.get_frame().get_form().getBtn_validate_();
		_jb_erase = _view.get_frame().get_form().getBtn_erase_();
		_jtf_first_name = _view.get_frame().get_form().getJtf_first_name_();
		_jtf_last_name = _view.get_frame().get_form().getJtf_last_name_();
		_jtf_postal = _view.get_frame().get_form().getJtf_postal_();
		_jtf_age = _view.get_frame().get_form().getJtf_age_();
		_jtf_mail = _view.get_frame().get_form().getJtf_mail_();
		/*Ajout des Action listener sur les boutons*/
		_jb_validate.addActionListener(this);
		_jb_erase.addActionListener(this);
		
	}
	@Override
	public void actionPerformed(ActionEvent e) {
		boolean ok_l = false;
		boolean ok_f = false;
		boolean ok_p = false;
		boolean ok_a = false;
		boolean ok_m = false;
		if(e.getSource() == _jb_validate)
		{
			
			String first = _jtf_first_name.getText();
			if (first != null && first.length() > 0)
			{	
				System.out.println("first name : "+ first);
				ok_f = true;
			}
			else
				{
					ok_f = false;
				}

			String last = _jtf_last_name.getText();
			if (last != null && last.length() > 0)
			{
				System.out.println("last name : "+ last);
				ok_l = true;
			}
			else
				{
					ok_l = false;
				}
			
			String postal = _jtf_postal.getText();
			if (postal != null && postal.length() > 0)
			{
				if (postal.matches("[0-9]{5}"))
				{
					System.out.println("postal : "+ postal);
					ok_p = true;
				}
			}
			else
				{
					ok_p = false;
				}
			
			String age = _jtf_age.getText();
			if (age != null && age.length() > 0)
			{
				if (age.matches("[0-9]+"))
				{
					System.out.println("age : "+ age);
					ok_a = true;
				}
			}
			else
				{
					ok_a = false;
				}
			
			String email = _jtf_mail.getText();
			if (email != null && email.length() > 0)
			{
				//"[a-zA-Z0-9_.]*@[a-zA-Z]+.[a-zA-Z]+"
				//^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)+$
				if (email.matches("^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)+$"))
				{
					System.out.println("mail : "+ email);
					ok_m = true;
				}
			}
			else
				{
					ok_m = false;
				}
			
			if(ok_p && ok_l && ok_f && ok_a && ok_m)
			{
				boolean req_ok = _model.insert_adh(first, last, postal, age, email);
				if(req_ok)
				{
					JOptionPane.showMessageDialog(null, "Adhérent ajouté avec succès", "Win !", JOptionPane.INFORMATION_MESSAGE, _img);
					_jtf_first_name.setText("");
					_jtf_last_name.setText("");
					_jtf_postal.setText("");
					_jtf_age.setText("");
					_jtf_mail.setText("");
				}
				else
				{
					JOptionPane.showMessageDialog(null, "Ajout Impossible, déjà adhérent ?", "Ajout Impossible", JOptionPane.ERROR_MESSAGE);
				}
			}
		}
		if (e.getSource() == _jb_erase)
		{
			_jtf_first_name.setText("");
			_jtf_last_name.setText("");
			_jtf_postal.setText("");
			_jtf_age.setText("");
			_jtf_mail.setText("");
		}
	}
}
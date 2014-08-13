package view;

import java.awt.GridLayout;

import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JTextField;

public class Formulaire extends JPanel {

	private static final long serialVersionUID = 1L;
	private JButton btn_validate_;
	private JButton btn_erase_;
	private JTextField jtf_first_name_;
	private JTextField jtf_last_name_;
	private JTextField jtf_postal_;
	private JTextField jtf_age_;
	private JTextField jtf_mail_;
	
	public JTextField getJtf_mail_() {
		return jtf_mail_;
	}

	public Formulaire() {
		super();
		btn_validate_ = new JButton("valider");
		btn_erase_ = new JButton("effacer");

		GridLayout gl = new GridLayout(6, 2);
		gl.setHgap(5);
		gl.setVgap(5);
		this.setLayout(gl);
		
		jtf_first_name_ = new JTextField();
		jtf_last_name_ = new JTextField();
		jtf_postal_ = new JTextField();
		jtf_age_ = new JTextField();
		jtf_mail_ = new JTextField();
		
		this.add(new JLabel("nom"));
		this.add(jtf_first_name_);
		this.add(new JLabel("prenom"));
		this.add(jtf_last_name_);
		this.add(new JLabel("code postal"));
		this.add(jtf_postal_);
		this.add(new JLabel("Age"));
		this.add(jtf_age_);
		this.add(new JLabel("E-mail"));
		this.add(jtf_mail_);
		this.add(btn_validate_);
		this.add(btn_erase_);
	}

	public JButton getBtn_validate_() {
		return btn_validate_;
	}

	public void setBtn_validate_(JButton btn_validate_) {
		this.btn_validate_ = btn_validate_;
	}

	public JButton getBtn_erase_() {
		return btn_erase_;
	}

	public void setBtn_erase_(JButton btn_erase_) {
		this.btn_erase_ = btn_erase_;
	}

	public JTextField getJtf_first_name_() {
		return jtf_first_name_;
	}

	public void setJtf_first_name_(JTextField jtf_first_name_) {
		this.jtf_first_name_ = jtf_first_name_;
	}

	public JTextField getJtf_last_name_() {
		return jtf_last_name_;
	}

	public void setJtf_last_name_(JTextField jta_last_name_) {
		this.jtf_last_name_ = jta_last_name_;
	}

	public JTextField getJtf_postal_() {
		return jtf_postal_;
	}

	public void setJta_postal_(JTextField jtf_postal_) {
		this.jtf_postal_ = jtf_postal_;
	}

	public JTextField getJtf_age_() {
		return jtf_age_;
	}
}

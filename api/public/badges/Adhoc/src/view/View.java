package view;

import modele.Model;

public class View implements InterfaceVue{
	private Model _model;
	private Content _frame;
	
	public View(Model model)
	{
		_model = model;
		_frame = new Content(_model);
		_frame.setSize(350, 420);
		_frame.setResizable(false);
		_frame.setVisible(true);
	}
	public Content get_frame() {
		return _frame;
	}

	public void set_frame(Content frame) {
		_frame = frame;
	}
}

package view;

import java.awt.Graphics;

public class VueImage extends VueAbstract{

	/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	public VueImage(String file)
	{
		image = creerImage(file);
		imageHeight = image.getHeight(this);
		imageWidth = image.getWidth(this);
		setPreferredSize(dimImage);
		// on supprime le layout du panel pour pouvoir placer les
		// boutons-stations où et comment on veut.
		// Sinon, ils prennent toute la place dispo... Pas cool.
		setLayout(null);
	}
	// affichage de l'image
		public void paintComponent(Graphics g) {
			super.paintComponent(g);
			setOpaque(false);
			g.drawImage(image, 75, 10, 200, 200, null);
			repaint();
		}
}

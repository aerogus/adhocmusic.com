package view;

import java.awt.BorderLayout;
import java.awt.Dimension;
import java.awt.Image;
import java.awt.Rectangle;
import java.io.IOException;
import java.io.InputStream;

import javax.imageio.ImageIO;
import javax.swing.JPanel;


public abstract class VueAbstract extends JPanel implements InterfaceVue {

		/**
	 * 
	 */
	private static final long serialVersionUID = 1L;
		public Image image;
		
		public BorderLayout borderLayout1 = new BorderLayout();
		public static int imageWidth;
		public static int imageHeight;
		public Dimension dimImage;
		public Rectangle rec;

		/**
		 * methode de creation d'une image
		 * 
		 * @param URL
		 *            adresse de l'image à créer
		 * @return img l'image créée
		 */
		public static Image creerImage(String URL) {
			Image img = null;
			// creation de l'image
			try 
			{
				ClassLoader classLoader = Thread.currentThread().getContextClassLoader();
				InputStream input = classLoader.getResourceAsStream(URL);
				img = ImageIO.read(input);
			}
			catch (IOException e1)
			{
				e1.printStackTrace();
			}

			// on retourne l'image a l'appelant
			return img;
		}

	}


package dixgag;

import java.io.*;
import java.nio.file.Files;
import java.util.Collections;
import java.util.List;
import java.util.Arrays;

public class DixGag {

  public static void main(String[] args) {

    File répertoireGags = new File("./gags");

    List<File> gags = null;
    try {
      gags = Arrays.asList(répertoireGags.listFiles());
    } catch (SecurityException e) {
      System.out.println("Erreur "+e.getMessage());
      e.printStackTrace();
    }

    if (gags == null || gags.size() == 0) {
      System.out.println("Aucun gag trouvé");
    } else {
      int compteur = 0;
      Collections.shuffle(gags);

      for (File gag : gags) {
        String texte = "";

        try {
          texte = new String(Files.readAllBytes(gag.toPath()));
        } catch (IOException e) {
          System.out.println("Erreur de lecture "+e.getMessage());
          e.printStackTrace();
        }

        compteur++;
        System.out.println("Gag "+compteur+" : "+texte);

        try {
          System.in.read();
        } catch (IOException e) {
          System.out.println("Erreur impossible... félicitations!");
          e.printStackTrace();
        }
      }
    }
  }
}

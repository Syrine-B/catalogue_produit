# catalogue_produit
Mini site qui permet d'avoir un catalogue produit et un référentiel document

Le code de cet outil est séparé en 3. 
- Tout ce qui est en lien avec les utilisateurs dans le dossier utilisateur.
- Tout ce qui est en lien avec le référentiel produit ou catalogue produit dans le dossier Produit
- Tout ce qui est en lien avec le référentiel document dans le dossier Documents

  La page d'acceuil est "general". Cette page permet le renvoi dans chacun des dossier en fonction su choix de l'utilisateur.

  Les pages ne sont pas accessible a tous.
  Déja si l'utilisateur n'a pas de compte, ce dernier ne peux pas atteindre la page "general".
  Les autres pages sont accessible en fonction du statut de l'utilisateur connecter.

  La seul facon d'avoir un compte est la création de ce dernier par l'administrateur. Une fois le compte crée le futur utilisateur recois un mail avec son identifiant et son mot de passe.


La fonction d'ajout de document contient une grosse particularité. Comme je souhaitais pouvoir ajouter mes documents dans une arborescence spécifique et non dans un seul emplacement. Il n'y a que la racine de codé. Le reste c'est l'utilisateur qui ajoute le chemin qu'il veux pour le document. 
Cela j'en suis consciente pose des problèmes de sécurité. C'est pour cela que les pages sont bloquer aux utilisateurs autre qu'administrateur avec de nombreuses vérifications. ce site étant utiliser que par des membres de mon équipe je n'ai pas renforcé la sécurité plus que cela mais pour une utilisation plus large il faut corriger

  La structure de la BDD est visible dans "structure BDD.SQL"

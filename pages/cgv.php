<?php
require_once '../component/session.php';
require_once '../component/header.php';
require_once '../functions/sql.php';
require_once 'bdd.php';

?>
<style>
    .global{
        width: 80%;
        margin-left : 10%;
    }
    h1{
        text-align: center;
    }
    /* .infos{
        text-align: center;
    } */

    .content{
        height: 100%;
    }
</style>
<div class="content">      
        <div class="global">
            <h1>Conditions générales de vente </h1>
        
    <div class="infos">
    <p>Les termes utilisés dans les présentes comportant une majuscule sans qu’ils aient préalablement été définis ont le sens qui leur est donné ci-après :
        <br><br>
    « Client » désigne une personne physique, majeure, agissant pour ses besoins personnels et disposant de la pleine capacité juridique de s’engager au titre des présentes. 
    <br>
    « Conditions de vente du tarif réservé » désigne les conditions particulières de chaque réservation effectuée par le Client.
    <br>
    « Confirmation de réservation » désigne le document récapitulant les détails de la réservation faite par le Client, envoyé par le site Internet ou l’Hôtel au Client.
    <br>
    « Demande de réservation » désigne toute demande de réservation de chambre d’hôtel effectuée par le Client.
    <br>« Hôtel » désigne l’hôtel Romance Malesherbes, exploité par la SAS SOCIETE HOTELIERE DES ABBESSES au capital de 37 000 €, dont le siège social sis 129, rue Cardinet – 75017 PARIS, immatriculée au RCS de Paris sous le numéro 602 003 436.
    <br>
    « Partenaires » désigne tous prestataires de services ayant conclu un contrat de prestation de services ou accord de partenariat avec l’Hôtel.
    <br>
    « Service » désigne tout service de réservation de chambre d’hôtel effectuée par le Client sur le site Internet de l’Hôtel.
    <br>
    « Site Internet de l’Hôtel » désigne le site internet dédié à l’Hôtel accessible à l’adresse suivante
    <br>
    </p>
    </div>
    
    <br>
    <h3>ARTICLE 1 – Champ d’application</h3>
    <p>
    Les présentes Conditions Générales de Vente s’appliquent, sans restriction ni réserve à tout achat des services de réservation de chambres d’hôtel et de prestations annexes ("les Services") proposés par l’Hôtel ("le Prestataire" ou l’«Hôtel») aux consommateurs et clients non professionnels ("Les Clients ou le Client") sur le site Internet de l’Hôtel.
    Les caractéristiques principales des Services, sont présentées sur le site internet de l’Hôtel.
    Le Client est tenu d’en prendre connaissance avant toute réservation. Le choix et l’achat d’un Service est de la seule responsabilité du Client.    
    <br><br>
    Le Client déclare : <br>

    ● Avoir la pleine capacité juridique de s’engager au titre des présentes Conditions Générales de Ventes.<br>

    ● Effectuer la réservation de chambres d’hôtel et de prestations annexes pour ses besoins personnels.<br>

    ● Etre en mesure de sauvegarder et imprimer les présentes Conditions Générales de ventes.
    Les coordonnées de l’Hôtel sont les suivantes :<br>
    <br>
    Hôtel Roulet Dorian
    <br>
    126, rue je ne connais pas l'adresse
    <br>
    34000 MONTPELLIER
    <br><br>
    Ces conditions s’appliquent à l’exclusion de toutes autres conditions, et notamment celles applicables pour d’autres circuits de commercialisation des Services.
    <br><br>
    Toute réservation de chambres d’hôtel réalisée dans ces conditions implique la consultation et l’acceptation complète et sans réserve par le Client des conditions particulières du prestataire, des conditions de vente du tarif réservé et des présentes conditions générales de vente. Le Client déclare avoir obtenu de l’Hôtel toutes les informations nécessaires et disponibles sur le site Internet.
    <br><br>
    Les présentes Conditions Générales de Vente sont accessibles à tout moment sur le site Internet de l’Hôtel et prévaudront, le cas échéant, sur toute autre version ou tout autre document contradictoire.
    Sauf preuve contraire, les données enregistrées dans le système informatique du prestataire constituent la preuve de l’ensemble des transactions conclues avec le Client. Ainsi, la saisie des informations bancaires, l’acceptation des Conditions Générales de Vente, des Conditions de Vente du tarif ou de la Demande de réservation, à entre l’Hôtel et le Client la même valeur qu’une signature manuscrite sur support papier. Les Registres informatisés conservés dans les systèmes informatiques de l’Hôtel seront conservés dans des conditions raisonnables de sécurité et considérés comme des preuves de communication, commande et paiement intervenues entre l’Hôtel et le Client.
    <br><br>
    L’Hôtel assure la conservation de l’écrit constatant la conclusion du contrat sous format électronique ou papier pendant une durée maximale de 5 ans. 
    <br><br>
    Conformément à la loi Informatique et Libertés du 6 janvier 1978, le Client dispose, à tout moment, d’un droit d’accès, de rectification, et d’opposition à l’ensemble de ses données personnelles en écrivant par mail directement sur le site, dans le cas présent son compte et l'ensemble des données le concernant seront supprimées.
    <br><br>
    Les présentes Conditions Générales de Vente comprennent également la Charte sur les Données Personnelles.

    <!--Le Client déclare avoir pris connaissance des présentes Conditions Générales de Ventes (y compris la Charte sur les Données Personnelles) et les avoir acceptées en cochant la case prévue à cet effet avant la mise en œuvre de la procédure de réservation en ligne ainsi que des Conditions Générales d’Utilisation du site internet de l’Hôtel.-->
    <br><br>
    La validation de la réservation de Services par le Client vaut acceptation sans restriction ni réserve des présentes Conditions Générales de Vente (y compris la Charte sur les Données Personnelles).
    <br><br>
    Le Client reconnaît avoir la capacité requise pour contracter et acquérir les Services proposés sur le site internet de l’Hôtel.
    <br><br>
    Ces Conditions Générales de Vente pouvant faire l’objet de modifications ultérieures, la version applicable à l’achat du Client est celle en vigueur sur le site internet à la date de la réservation.
    <br><br>
    Les présentes Conditions Générales de Vente sont applicables pendant la durée de mise en ligne des services proposées par l’Hôtel sur le Site internet de l’Hôtel. L’Hôtel se réserve le droit de fermer temporairement ou définitivement l’accès de son Site internet.
    <br><br>
    </p>
    <h3>ARTICLE 2 – Réservations</h3>
    <p>
    Le Client sélectionne sur le site Internet les services qu’il désire réserver, selon les modalités suivantes :
    <br><br>
    1. Tout d'abord le client doit posséder un compte sur le site. ()
    <br>
    2. Sélection du type de chambre et du tarif
    <br>
    3. Vérification et validation du détail de la réservation, du montant total de la réservation
    <br>
    4. Saisie des coordonnées de sa carte bancaire en cas de garantie ou de prépaiement
    <br><br>
    <!-- 6. Consultation et acceptation des conditions générales de vente et des conditions du tarif sélectionné préalablement à la validation de sa réservation -->

    <!-- 7. Validation de sa réservation -->

    Le Client reconnait avoir pris connaissance de la nature, la destination et les modalités de réservation des Services proposées par l’Hôtel et avoir sollicité et obtenu les informations nécessaires pour effectuer sa réservation en toute connaissance de cause. Il est seul responsable de son choix de services et de leur adéquation à ses besoins, de telle sorte que la responsabilité de l’Hôtel ne peut être recherchée à cet égard.
    <br><br>
    Le Client s’engage à compléter les informations demandées sur la demande de réservation et atteste la véracité et l’exactitude des informations transmises.
    <br><br>
    Les informations contractuelles sont présentées en langue française et font l’objet d’une confirmation au plus tard au moment de la validation de la réservation par le Client.
    <br><br>
    L’enregistrement d’une réservation sur le site du Prestataire est réalisé lorsque le client clique sur valider ma réservation. Le Client a la possibilité de vérifier le détail de sa réservation, son prix total avant de confirmer son acceptation (article 1127-2 du Code Civil). Cette validation implique l’acceptation de l’intégralité des présentes Conditions Générales de Vente et constituent une preuve du contrat de vente.
    <br><br>
    Il appartient donc au Client de vérifier l’exactitude de la réservation et de signaler immédiatement toute erreur.
    <br><br>
    La vente de Services ne sera considérée comme définitive que le jour de début de sa réservation.
    <br><br>
    Toute réservation passée sur le site internet de l’Hôtel constitue la formation d’un contrat conclu à distance entre le Client et le Prestataire.
    <br><br>
    L’Hôtel se réserve le droit d’annuler ou de refuser toute réservation d’un Client avec lequel il existerait un litige relatif au paiement d’une réservation antérieure.
    <br><br>
    Chaque réservation est nominative et ne peut en aucun cas être cédée à un tiers.
    <br><br>

    Annulation / Modification d’une réservation déjà débuté :
    <br>
    Le client devra versé l'intégralité du prix de la chambre s'il n'annule pas sa réservation avant le jour de début (jour de début non compris).
    </p> 
    <br>

    <h3>ARTICLE 3 – TARIFS</h3>
    <p>
    Les Services proposés par le Prestataire sont fournis aux tarifs en vigueur sur le site internet de l’Hôtel lors de l’enregistrement de la réservation par le Prestataire. Les prix sont exprimés en Euros, HT et TTC.
    <br><br>
    Ces tarifs sont fermes et non révisables pendant leur période de validité, telle qu’indiqué sur le site internet de l’Hôtel, le Prestataire se réservant le droit, hors cette période de validité, de modifier les prix à tout moment.
    <br><br>
    Les tarifs sont indiqués avant et lors de la réservation faite par le Client. Ils s’entendent par chambre pour le nombre de personnes et la date sélectionnée.
    <br><br>
    Les tarifs sont confirmés au Client en montant TTC (hors Taxes de séjour) dans la devise commerciale de l’Hôtel. Ils tiennent compte de la TVA au taux applicable au jour de la réservation ; tout changement du taux applicable à la TVA sera automatiquement répercuté sur les tarifs indiqués à la date de facturation. Il sera de même de toute modification ou instauration de nouvelles taxes légales ou réglementaires imposées par les Autorités compétentes.
    <br><br>
    Sauf mention contraire sur le Site, les prestations annexes (petit-déjeuner, etc…) ne sont pas incluses dans le prix.
    <br><br>
    La conversion en monnaie étrangère est donnée à titre indicatif et non contractuelle. Si un tarif implique un paiement directement à l’Hôtel lors de l’arrivée ou du départ du Client et que la monnaie du Client n’est pas la même que celle de l’Hôtel, le tarif débité par l’Hôtel est susceptible d’être différent de celui qui a été communique lors de la réservation, compte tenu de l’évolution du taux de change entre la date de réservation et la date de paiement.
    <br>
    Une facture est établie par le Prestataire et remise au Client lors de la fourniture des Services réservés.
    </p>
    <br>

    <h3>ARTICLE 4 – MODALITES de paiement</h3>
    <p>
    En cas de paiement au comptant au jour de la réservation (Tarif Non Annulable Non Remboursable) :
    <br>
    Le prix est payable comptant, en totalité au jour de la confirmation de la réservation par le Client, selon les modalités précisées à l’article «Réservations» ci-dessus, par voie de paiement sécurisé :
    <br>
    – par cartes bancaires : Visa, MasterCard, American Express, autres cartes bleues (Ecard bleue).
    <br><br>
    Lors de la réservation, le Client communique ses coordonnées bancaires en précisant le nom de la carte bancaire, le numéro de la carte bancaire, la date de validité (la carte bancaire doit être valable jusqu’à la date de fin du séjour) et le cryptogramme.
    <br><br>
    Les données de paiement sont échangées en mode crypté grâce au protocole SSL.
    <br><br>
    Le Client se présentera à l’Hôtel avec la carte bancaire lui ayant permis de réaliser le paiement de la réservation. Il pourra lui être demandé de présenter une pièce d’identité dans le cadre des procédures de prévention contre la fraude aux cartes bancaires.
    <br><br>
    Les paiements effectués par le Client ne seront considérés comme définitifs qu’après encaissement effectif des sommes dues par le Prestataire.
    </p>
    <br>
    <h3>ARTICLE 5 – Fourniture des Prestations</h3>
    <p>
    Les Services réservés par le Client, qui comprennent les prestations de réservation de chambres d’hôtel et de prestations annexes seront fournis selon les modalités suivantes, dans les conditions prévues aux présentes Conditions Générales de Vente complétées par les Conditions de vente du Tarif dont le Client a pris connaissance et qu’il a acceptées lors de sa réservation sur le site Internet de l’Hôtel.
    <br><br>
    A son arrivée, il sera demandé au Client de présenter sa pièce d’identité afin de s’assurer de son obligation de compléter une Fiche de Police.
    <br><br>
    L’Hôtel est un espace entièrement non-fumeur. Le client sera tenu responsable des dommages directs et/ou indirects, consécutifs, résultant de l’acte de fumer dans l’Hôtel. Il sera par conséquent, redevable de l’intégralité du montant des frais de nettoyage et de remise en l’état initial de l’élément ou l’espace endommagé.
    <br><br>
    Les animaux, dès lors qu’ils sont tenus en laisse ou en cage dans les parties communes de l’établissement, peuvent être acceptés selon la politique en vigueur de l’Hôtel. Pour des raisons d’hygiène, les animaux ne sont pas admis dans les salles de restauration.
    <br><br>
    Les effets personnels du Client laissés dans la chambre de l’Hôtel, notamment à l’extérieur du coffre-fort ou dans les espaces publics de l’Hôtel relèvent de son entière responsabilité. L’Hôtel ne saurait être tenu responsable de la perte, du vol, des détériorations ou des dommages causés auxdits effets.
    <br><br>
    Le client accepte et s’engage à utiliser la chambre en bon père de famille. Aussi tout comportement contraire aux bonnes mœurs et à l’ordre public amènera l’Hôtel à demander au Client de quitter l’établissement sans aucune indemnité et ou sans aucun remboursement si un règlement a déjà été effectué.
    <br><br>
    Le Client sera tenu responsable de l’intégralité des dommages directs et/ou indirects, consécutifs, dont il est l’auteur, constatés dans la chambre réservée ou qu’il pourrait causer au sein de l’Hôtel. En conséquence, il s’engage à indemniser l’Hôtel à hauteur du montant desdits dommages, sans préjudice des dommages et intérêts qui pourraient être dus, frais de procédure et d’avocats engagés par l’Hôtel.
    <br><br>
    Un accès WIFI permettant aux clients de se connecter à internet peut être proposé selon la Politique en vigueur de l’Hôtel. Le client s’engage à ce que les ressources informatiques mises à sa disposition par l’hôtel ne soient en aucune manière utilisées à des fins de reproduction, de représentation, de mise à disposition ou de communication au public d’œuvres ou d’objets protégés par un droit d’auteur ou par un droit voisin, tels que des textes, images, photographies, œuvres musicales, œuvres audiovisuelles, logiciels et jeux vidéo, sans l’autorisation des titulaires des droits prévus aux livres Ier et II du code de la propriété intellectuelle lorsque cette autorisation est requise. Si le client ne se conforme pas aux obligations précitées, il risquerait de se voir reprocher un délit de contrefaçon (article L.335-3 du code de la propriété intellectuelle), sanctionné par une amende de 300.000 euros et de trois ans d’emprisonnement. Le client est par ailleurs tenu de se conformer à la politique de sécurité du fournisseur d’accès internet de l’hôtel, y compris aux règles d’utilisation des moyens de sécurisation mis en œuvre dans le but de prévenir l’utilisation illicite des ressources informatiques et de s’abstenir de tout acte portant atteinte à l’efficacité de ces moyens.
    <br><br>
    Sauf disposition expresse contraire, la Chambre sera mise à la disposition du Client le jour de son arrivée à 14 heures et le Client quittera la chambre le jour de son départ à 12 heures. A défaut, une nuitée supplémentaire sera facturée au Client. En cas de départ anticipé, le prix de la réservation restera inchangée.
    <br><br>
    Le Prestataire s’engage à faire ses meilleurs efforts pour fournir les Services réservés par le Client, dans le cadre d’une obligation de moyen.
    <br><br>
    Le Client disposera d’un délai de 7 jours à compter de sa date de départ de l’Hôtel pour émettre, par écrit, des réserves ou réclamations concernant la fourniture des Services, avec tous les justificatifs y afférents, auprès de l’Hôtel.
    <br><br>
    Aucune réclamation ne pourra être valablement acceptée en cas de non-respect de ces formalités et délais par le Client.
    <br><br>
    A défaut de réserves ou réclamations expressément émises dans ce délai par le Client lors de la réception des Services, ceux-ci seront réputés conformes à la réservation, en quantité et qualité.
    <br><br>
    En cas de délogement :
    <br>
    En cas d’évènement exceptionnel, cas de force majeure ou d’impossibilité de mettre la chambre réservée à disposition du Client, l’Hôtel de réserve la possibilité de faire héberger totalement ou partiellement le Client dans un hôtel de catégorie équivalente, pour des prestations de même nature et sous réserve de l’accord préalable du Client.
    </p>
    <br>
    
    <h3>ARTICLE 6 – DROIT DE RETRACTATION</h3>
    <p>
    Conformément à l’article L 221-28 du Code de la consommation, le Client ne dispose pas du droit de rétractation prévu à l’article L 221-18 du Code de la consommation, compte tenu de la nature des services fournis.
    <br>
    Le contrat est donc conclu de façon définitive dès la passation de la réservation par le Client selon les modalités précisées aux présentes Conditions générales de Vente.
    </p>
    <br>

    <h3>ARTICLE 7 – Responsabilité du Prestataire – Garantie</h3>
    <p>
    Le Prestataire garantit, conformément aux dispositions légales et sans paiement complémentaire, le Client, contre tout défaut de conformité ou vice caché, provenant d’un défaut de réalisation des Services réservés et effectivement payés dans les conditions et selon les modalités définies aux présentes Conditions Générales de Vente.
    <br><br>
    Les Services fournis par l’intermédiaire du site Internet de l’Hôtel sont conformes à la réglementation en vigueur en France. La responsabilité du Prestataire ne saurait être engagée en cas de non-respect de la législation du pays dans lequel les Services sont fournis, qu’il appartient au Client, qui est seul responsable du choix des Services demandés, de vérifier.
    </p>
    <br>

    <h3>ARTICLE 8 – Informatiques et Libertés</h3>
    <p>
    En application de la loi 78-17 du 6 janvier 1978, il est rappelé que les données nominatives qui sont demandés au Client sont nécessaires au traitement de sa réservation et à l’établissement des factures, notamment.
    <br><br>
    Ces données sont traitées et destinées à l’Hôtel et ne sont pas communiquées.
    <br><br>
    <!-- Par ailleurs, l’Hôtel est susceptible d’adresser par courrier électronique à ses clients sa lettre d’informations, des offres promotionnelles, un questionnaire de satisfaction suite à son séjour hôtelier. -->

    <!-- Le traitement des informations communiquées par l’intermédiaire du site internet de l’Hôtel a fait l’objet d’une déclaration auprès de la CNIL.
    -->
    Le Client dispose, conformément aux réglementations nationales et européennes en vigueur d’un droit d’accès permanent, de modification, de rectification et d’opposition s’agissant des informations le concernant.
    <br><br>
    Ce droit peut être exercé dans les conditions et selon les modalités définies sur le site internet de l’Hôtel.
    </p><br>
    <!-- La politique de protection des données personnelles est consultable dans la Charte de Protection des données personnelles consultable sur le Site Internet de l’Hôtel. -->

    <h3>ARTICLE 9 – Propriété intellectuelle</h3>
    <p>
    Le contenu du site internet de l’Hôtel est la propriété du Vendeur et est protégé par les lois françaises et internationales relatives à la propriété intellectuelle.
    <br><br>
    Toute reproduction totale ou partielle de ce contenu est strictement interdite et est susceptible de constituer un délit de contrefaçon.
    </p><br>

    <h3>ARTICLE 10 – Imprévision</h3>
    <p>
    Les présentes Conditions Générales de Vente excluent expressément le régime légal de l’imprévision prévu à l’article 1195 du Code civil pour toutes les opérations de Services du Prestataire au Client. Le Prestataire et le Client renoncent donc chacun à se prévaloir des dispositions de l’article 1195 du Code civil et du régime de l’imprévision qui y est prévu, s’engageant à assumer ses obligations même si l’équilibre contractuel se trouve bouleversé par des circonstances qui étaient imprévisibles lors de la conclusion de la vente, quand bien même leur exécution s’avèrerait excessivement onéreuse et à en supporter toutes les conséquences économiques et financières.

    </p><br>

    <h3>ARTICLE 11 – Force majeure</h3>
    <p>
    Les Parties ne pourront être tenues pour responsables si la non-exécution ou le retard dans l’exécution de l’une quelconque de leurs obligations, telles que décrites dans les présentes découle d’un cas de force majeure, au sens de l’article 1218 du Code civil.
    </p><br>

    <h3>Article 12 : DISPOSITIONS DIVERSES</h3>
    <p>
    Les présentes Conditions générales de ventes, la Charte des Données personnelles, les Conditions de vente du tarif réservé par le Client, la Demande de réservation, la Confirmation de réservation par le Client, constituent l’intégralité de l’accord des parties dans la limite de son objet. Ils remplacent et annulent, en conséquence, dans cette limite, tout accord verbal ou écrit qui leur serait antérieur.
    </br></br>
    Aucune tolérance, quelle qu’en soit la nature, l’ampleur, la durée ou la fréquence, ne pourra être considérée comme créatrice d’un quelconque droit et ne pourra conduire à limiter d’une quelconque manière que ce soit, la possibilité d’invoquer chacune des clauses des présentes Conditions Générales de Vente, à tout moment, sans aucune restriction.
    <br><br>
    Toute clause des présentes Conditions Générales de Vente qui viendrait à être déclarée nulle ou illicite par un juge compétent serait privée d’effet, mais sa nullité ne saurait porter atteinte aux autres stipulations, ni affecter la validité des Conditions Générales de Vente dans leur ensemble ou leurs effets juridiques.
    </p><br>
    

    <h3>ARTICLE 13 – Droit applicable – Langue</h3>
    <p>
    Les présentes Conditions Générales de Vente et les opérations qui en découlent sont régies et soumises au droit français.
    <br><br>
    Les présentes Conditions Générales de Vente sont rédigées en langue française. Dans le cas où elles seraient traduites en une ou plusieurs langues étrangères, seul le texte français ferait foi en cas de litige.
    </p><br>

    <h3>ARTICLE 14 – Litiges</h3>
    <p>
    Tous les litiges auxquels les opérations d’achat et de vente conclues en application des présentes conditions générales de vente pourraient donner lieu, concernant tant leur validité, leur interprétation, leur exécution, leur résiliation, leurs conséquences et leurs suites et qui n’auraient pu être résolues entre l’Hôtel et le Client seront soumis aux tribunaux compétents dans les conditions de droit commun.
    <br><br>
    Le Client est informé qu’il peut en tout état de cause recourir à une médiation conventionnelle, notamment auprès de la Commission de la médiation de la consommation (C. consom. art. L 612-1) ou à tout mode alternatif de règlement des différends (conciliation, par exemple) en cas de contestation.
    </p><br>

    <h3>ARTICLE 15 – Information précontractuelle – Acceptation du Client</h3>
    <p>
    Le Client reconnaît avoir eu communication, préalablement à la passation de sa réservation et à la conclusion du contrat, d’une manière lisible et compréhensible, des présentes Conditions Générales de Vente et de toutes les informations listées à l’article L. 221-5 du Code de la consommation, et notamment les informations suivantes :
    <br><br>
    ● les caractéristiques essentielles des Services, compte tenu du support de communication utilisé et du Service concerné ;
    <br>
    ● le prix des Services;
    <!-- et des frais annexes -->
    <br>
    ● en l’absence d’exécution immédiate du contrat, la date ou le délai auquel le Prestataire s’engage à fournir les Services réservés ;
    <br>
    ● les informations relatives à l’identité du Prestataire, à ses coordonnées postales, téléphoniques et électroniques, et à ses activités, si elles ne ressortent pas du contexte,
    <br>
    ● les informations relatives aux garanties légales et contractuelles et à leurs modalités de mise en œuvre ;
    <br>
    ● les fonctionnalités du contenu numérique et, le cas échéant, à son interopérabilité ;
    <br>
    ● la possibilité de recourir à une médiation conventionnelle en cas de litige ;
    <br>
    ● les informations relatives aux conditions contractuelles importantes.
    <br>
    ● les moyens de paiement acceptés.
    </p>
    <br>   
    <p>  Le fait pour une personne physique (ou morale), de réserver sur le site Internet de l’Hôtel emporte adhésion et acceptation pleine et entière des présentes Conditions Générales de Vente et obligation au paiement des Services commandés, ce qui est expressément reconnu par le Client, qui renonce, notamment, à se prévaloir de tout document contradictoire, qui serait inopposable au Prestataire.
    </p>
</div>

</div>  

<?php require_once '../component/footer.php';
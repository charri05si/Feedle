<div class ="row">
    <div class="col-lg-12">
        <h1 class="page-header">Liste des produits</h1>
    </div>
</div>

<!-- Recherche -->
<div class ="row">
    <div class="col-lg-12">
        <label>Filtre de recherche :</label>
    </div>
    <div class="col-lg-12">
        <div class="alert alert-dismissable alert-info">
           <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
           Des commandes sont effectué automatiquement.
        </div>
    </div>

    <div class="form-group input-group col-lg-3">  
        <span class="input-group-addon">Marque :</span>
        <input class="form-control"></input>
    </div>

      <div class="form-group input-group col-lg-3">  
         <span class="input-group-addon">Catégorie :</span>
         <input class="form-control"></input>
    </div>

    <div class="form-group input-group col-lg-3">
        <span class="input-group-addon">Sous-catégorie :</span>
        <input class="form-control"></input>
    </div>

    <div class="form-group input-group col-lg-3">
        <span class="input-group-addon">Nom :</span>
        <input class="form-control"></input>
    </div>
</div>

<!-- Contenue -->
<div class="row">
    <div class="col-lg-12">
        <!-- LOADER -->
        <div id="loader">
            <h1>Chargement ...</h1>
            <div class="progress progress-striped active">
                <div class="progress-bar progress-bar-success" style="width: 100%"></div>
            </div>
        </div>
        <!-- FIN LOADER -->
        <!-- TABLE -->
        <div class="table table-responsive" id="data" hidden>
            <table class="table table-bordered table-hover table-striped tablesorter">
                <thead>
                    <tr>
                        <th class="header">Identifiant <i class="fa fa-sort"></i></th>
                        <th class="header">Nom <i class="fa fa-sort"></i></th>
                        <th class="header">Prix <i class="fa fa-sort"></i></th>
                        <th class="header">Qte en stock <i class="fa fa-sort"></i></th>
                        <th class="header">Commander <i class="fa fa-sort"></i></th>
                    </tr>
                </thread>
                <tbody id="table_rows">
                    <!-- <tr>
                        <td>1</td>
                        <td>0</td>
                        <td>1</td>
                        <td>0</td>
                        <td>1</td>
                    </tr> -->
                </tbody>
            </table>
        </div>
        <!--FIN TABLE -->
        <!--LOADER INFINITE scroll -->
         <div id="loader-scroll" hidden>
             <div class="col-lg-4"></div>
             <div class="col-lg-4">
                 <div class="progress progress-striped active">
                    <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                </div>
             </div>
             <div class="col-lg-4"></div>
        </div>
        <!-- FIN INFINTE SCROLL -->
    </div>
</div>

<script type="text/javascript">
    var page = 1;
    ajax($('#table_rows'),{c:'Produit',a:'data_liste', p:page}, false, true);
    
    //infinite scroll
    $(window).scroll(function()
    {
        if($(window).scrollTop() === $(document).height() - $(window).height())
        {
           page++;
           $('#loader-scroll').show();
           ajax($('#table_rows'),{c:'Produit',a:'data_liste', p:page}, false, true);
        }
    });
    

  
</script>
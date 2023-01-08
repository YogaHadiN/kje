@extends('layout.master')

@section('title') 
Klinik Jati Elok | Basic

@stop
@section('page-title') 
<h2>Basic</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Basic</strong>
            </li>
</ol>

@stop
@section('content') 
<select class="js-select-two" name="state">
</select>
@stop
@section('footer') 
    <script charset="utf-8">
        $(document).ready(function() {
            $(".js-select-two").select2(ajax_search( 'jenis_tarifs/ajax/cari', 'Pilih Jenis Tarif'  ));

            function formatRepo (repo) {
              if (repo.loading) {
                return repo.text;
              }

              var $container = $(
                "<div class='clearfix select2-result-repository'>" +
                  "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
                  "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__title'></div>" +
                    "<div class='select2-result-repository__description'></div>" +
                    "<div class='select2-result-repository__statistics'>" +
                      "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
                      "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
                      "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
                    "</div>" +
                  "</div>" +
                "</div>"
              );

              $container.find(".select2-result-repository__title").text(repo.full_name);
              $container.find(".select2-result-repository__description").text(repo.description);
              $container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
              $container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
              $container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");

              return $container;
            }

            function formatRepoSelection (repo) {
              return repo.full_name || repo.text;
            }    
        });

    </script>
    
@stop

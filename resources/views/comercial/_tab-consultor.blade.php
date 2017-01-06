<div class="row">
     <div class="col-md-12">
        <div class="well bs-component">
        <form class="form-horizontal" id="frm-consultor" action="{{ url('comercial/performance') }}" method="post">
            <fieldset>
              <legend>Por Consultor</legend>
              <div class="form-group">
                <label for="period" class="col-md-2 control-label">Periodo</label>

                <div class="col-md-2">
                  <select id="period" name="from-month" class="form-control">
                    {!! Helper::monthsOpt() !!}
                  </select>
                </div>
                <div class="col-md-2">
                  <select id="period" name="from-year" class="form-control">
                    {!! Helper::yearsOpt() !!}
                  </select>
                </div>
                <div class="col-md-2 text-center"><h4>a</h4></div>
                <div class="col-md-2">
                  <select id="period" name="to-month" class="form-control">
                    {!! Helper::monthsOpt() !!}
                  </select>
                </div>
                <div class="col-md-2">
                  <select id="period" name="to-year" class="form-control">
                    {!! Helper::yearsOpt() !!}
                  </select>
                </div>
              </div>

              
             <div class="form-group">
                <label for="consultores" class="col-md-2 control-label">Consultores</label>

                <div class="col-md-4">
                  <select id="consultores" name="consultores-base" multiple="" class="form-control">
                    {!! Helper::htmlConsultants() !!}
                  </select>
                </div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-default" id="add">&gt;&gt;</button>
                    <button class="btn btn-default" id="remove">&lt;&lt;</button>
                </div>
                <div class="col-md-4">
                  <select id="consultores" name="consultores[]" multiple="" class="form-control"></select>
                  <small class="help-block" id="err-consultores">Los consultores son requeridos</small>
                </div>
            </div>

              <div class="form-group">
                <div class="col-md-10 col-md-offset-2">
                  <button id="report" class="btn btn-primary _action">Reporte</button>
                  <button id="graph" class="btn btn-primary _action" >Gráfico</button>
                  <button id="cake" class="btn btn-primary _action">Pastel</button>
                </div>
              </div>
            </fieldset>
            <input name="_action" value="" type="hidden">
            {{ csrf_field() }}
          </form>

          </div>
          <!-- END form -->

            @if(isset($action) && $action == 'report')
            <!-- report section -->
            <div class="row">
                <div class="col-md-12">
                    @include('comercial._consultor-list', ['data' => $data] )    
                </div>
            </div>
            <!-- END report section-->
            @endif
            
            @if(isset($action) && $action == 'graph')
            <!-- Graph section -->
            @include('comercial._consultor-graph', ['data' => $data] )
            <!-- END Graph Section -->
            @endif

            @if(isset($action) && $action == 'cake')
            <!-- Donut Chart section -->
            @include('comercial._consultor-donut', ['data' => $data] )
            <!-- END Donut Chart section -->
            @endif

     </div>
</div>
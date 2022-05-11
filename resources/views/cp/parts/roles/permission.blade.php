<div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile js-permissions-list">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="fa fa-key"></i>
			</span>
            <h3 class="kt-portlet__head-title">Permissions
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-actions">
                <a href="javascript:;" class="uncheck-all">Uncheck all</a>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="horizontal-form">
            <div class="form-body">
                <div class="row permissions-row {{ isset($isRole)?"permissions-role":"" }}">
                    @foreach($actions as $action)
                        <div class="col-md-4">
                            <div class="kt-portlet kt-portlet--height-fluid box-permissions green">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label caption-wcheckbox">
                                        <label class="checkbox-inline parent-check">
                                            <input type="checkbox" class="mycheckbox pcheckbox" value="0"/>
                                            <span class="checkbox-style">
                                             <i class="fa fa-check"></i>
                                            </span>
                                            <i class="{{ $action->icon }}"></i>
                                            <span class="label-checkbox">{{ $action->group_name }}</span>
                                        </label>
                                    </div>
                                    <div class="kt-portlet__head-toolbar">
                                        <a href="javascript:;" data-ktportlet-tool="toggle"
                                           class="btn btn-sm btn-icon-md">
                                            <i class="la la-angle-down"></i></a>
                                    </div>
                                </div>
                                <div class="kt-portlet__body collapse-body form">
                                    <div class="horizontal-form">
                                        <div class="form-body">
                                            <div class="permissions-checks">
                                                <ul>
                                                    <li>
                                                        <label
                                                            class="kt-checkbox kt-checkbox--brand parent-check {{ (isset($roleActionsDefault) && in_array($action->id,$roleActions) && in_array($action->id,$roleActionsDefault))?"blue":"" }}
                                                            {{ (isset($roleActionsDefault) && in_array($action->id,$roleActions) && !in_array($action->id,$roleActionsDefault))?"green":"" }}
                                                            {{ (isset($roleActionsDefault) && !in_array($action->id,$roleActions) && in_array($action->id,$roleActionsDefault))?"red":"" }}
                                                            {{ (isset($roleActionsDefault) && !in_array($action->id,$roleActions) && !in_array($action->id,$roleActionsDefault))?"black":"" }}">
                                                            {!! Form::checkbox('action[]',$action->id,(!$errors->has('') && in_array($action->id,$roleActions))?true:null, array('class'=>'mycheckbox ccheckbox',"data-parent"=>"parent".$action->id)) !!}
                                                            {{ $action->name->{$locale} }}<span></span>
                                                        </label>
                                                    </li>
                                                    @foreach($action->actions as $subAction)
                                                        <li>
                                                            <label
                                                                class="kt-checkbox kt-checkbox--brand parent-check {{ (isset($roleActionsDefault) && in_array($subAction->id,$roleActions) && in_array($subAction->id,$roleActionsDefault))?"blue":"" }}
                                                                {{ (isset($roleActionsDefault) && in_array($subAction->id,$roleActions) && !in_array($subAction->id,$roleActionsDefault))?"green":"" }}
                                                                {{ (isset($roleActionsDefault) && !in_array($subAction->id,$roleActions) && in_array($subAction->id,$roleActionsDefault))?"red":"" }}
                                                                {{ (isset($roleActionsDefault) && !in_array($subAction->id,$roleActions) && !in_array($subAction->id,$roleActionsDefault) )?"black":"" }}">
                                                                {!! Form::checkbox('action[]',$subAction->id,
                                                                (!$errors->has('') && in_array($subAction->id,$roleActions))?true:null,
                                                                array('class'=>'mycheckbox ccheckbox',"data-child"=>"parent".$action->id)) !!}
                                                                {{ $subAction->group_name?$subAction->group_name:$subAction->name->{$locale} }}
                                                                <span></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

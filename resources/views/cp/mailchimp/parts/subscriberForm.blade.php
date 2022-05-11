{!! Form::open(["class"=>"form-validation updatemember-form"]) !!}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <label class="control-label">Email</label>
            <input name="email" type="text" value="{{$member['email_address']??""}}"
                   class="form-control txtinput-required txtinput-email input-emailmember"/>
        </div>
        <div class="col-md-12 mt-4">
            <div class="row">
                <div class="col-md-6">
                    <label class="control-label">First Name</label>
                    <input name="first_name" type="text" value="{{$member['merge_fields']['FNAME']??""}}"
                           class="form-control txtinput-required"/>
                </div>
                <div class="col-md-6">
                    <label class="control-label">Last Name</label>
                    <input name="last_name" type="text" value="{{$member['merge_fields']['LNAME']??""}}"
                           class="form-control txtinput-required"/>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="form-group">
                <label>Groups</label>
                <div class="kt-checkbox-inline">
                    @if($member)
                        @foreach($member['interests'] as $key=>$group)
                            <label
                                class="kt-checkbox kt-checkbox--bold kt-checkbox--success parent-check">
                                <input type="checkbox"
                                       class="mycheckbox ccheckbox"
                                       data-parent="parent2"
                                       name="groups[]"
                                       value="{{ $key }}"
                                    {{$group ?"checked":"" }}> {{ $groups[$key] }}
                                <span></span>
                            </label>
                        @endforeach
                    @else
                        @foreach($groups as $key=>$group)
                            <label
                                class="kt-checkbox kt-checkbox--bold kt-checkbox--success parent-check">
                                <input type="checkbox"
                                       class="mycheckbox ccheckbox"
                                       data-parent="parent2"
                                       name="groups[]"
                                       value="{{ $key }}"> {{ $group }}
                                <span></span>
                            </label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-success">Send</button>
</div>
{!! Form::close() !!}

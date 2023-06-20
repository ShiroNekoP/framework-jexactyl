@extends('layouts.admin')

@section('title')
    Blueprint
@endsection

@section('content-header')
    <img src="/assets/extensions/blueprint/logo.jpg" alt="logo" style="float:left;width:30px;height:30px;border-radius:3px;margin-right:5px;">
    <a href="https://ptero.shop" target="_blank">
        <button class="btn btn-gray-alt pull-right"><i class="bx bx-globe"></i></button>
    </a>
    <h1 ext-title>Blueprint<tag mg-left blue>{{ $bp->version() }}</tag></h1>
@endsection

@section('content')
    {{ $bp->serve() }}
    {{ $telemetry->send("SERVE_BLUEPRINT_ADMIN") }}
    <p>Blueprint is the framework that powers all Blueprint-compatible extensions, enabling multiple extensions to be installed and used simultaneously.</p>
    <div class="row">
        <div class="col-xs-3">

            <!-- Overview -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class='bx bxs-shapes' style='margin-right:5px;'></i></i>Overview</h3>
                </div>
                <div class="box-body">
                    <p>You are currently using version <code>{{ $bp->version() }}</code>.</p>
                </div>
            </div>

            <!-- Pulse -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class='bx bx-pulse' style='margin-right:5px;'></i>Pulse</h3>
                </div>
                <div class="box-body">
                    <p>This element is currently not functional. In the future this will show problems with your Blueprint installation.</p>
                </div>
            </div>

            <!-- Terminal -->
            @if($bp->dbGet('developer') == "true")
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class='bx bxs-terminal' style='margin-right:5px;'></i>Terminal</h3>
                    </div>
                    <div class="box-body">
                        <form action="" method="POST">
                            <div class="col-xs-12" style="padding-top:5px;">
                                <input type="text" required name="developer:cmd" id="developer:cmd" value="{{ $bp->dbGet('developer:cmd') }}" class="form-control" style="height:40px;width:100%;"/>
                                <p class="text-muted small">Be careful with what you run, some commands may end up breaking this page.</p>
                                {{ csrf_field() }}
                                <button type="submit" name="_method" value="PATCH" class="btn btn-gray-alt btn-sm pull-right" style="display:none;">Send</button>
                            </div>
                            <div class="col-xs-12" style="padding-top:10px;">
                                @if($bp->dbGet('developer:log') != "")
                                    <code>{{ $bp->dbGet('developer:log') }}</code>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                {{ $bp->dbSet('developer:log', '') }}
                {{ $bp->dbSet('developer:cmd', '') }}
            @endif

        </div>
        <div class="col-xs-9">
            <form action="" method="POST">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class='bx bxs-cog' style='margin-right:5px;'></i>Configuration</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <label class="control-label">Telemetry</label>
                                <select class="form-control" name="telemetry">
                                    <option value="true">Enabled</option>
                                    <option value="false" @if($bp->dbGet('telemetry') != "true") selected @endif>Disabled</option>
                                </select>
                                <p class="text-muted small">Automatically share anonymous usage data with Blueprint.</p>
                            </div>
                            <div class="col-xs-4">
                                <label class="control-label">ID</label>
                                <input type="text" required name="panel:id" id="panel:id" value="{{ $bp->dbGet('panel:id') }}" class="form-control" readonly/>
                                <p class="text-muted small">Randomly generated string with your version that is used as a panel identifier.</p>
                            </div>
                            <div class="col-xs-4">
                                <label class="control-label">Developer Mode</label>
                                <select class="form-control" name="developer">
                                    <option value="true">Enabled</option>
                                    <option value="false" @if($bp->dbGet('developer') != "true") selected @endif>Disabled</option>
                                </select>
                                <p class="text-muted small">Enable or disable developer-oriented features.</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {{ csrf_field() }}
                        <button type="submit" name="_method" value="PATCH" class="btn btn-gray-alt btn-sm pull-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

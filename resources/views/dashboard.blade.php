@extends('layouts.master-layout')

@section('title', 'Dashboard | NBUnify HRMS')

@section('content')

    <div class="page active" id="page-dashboard">


        <!-- 🌸 WELCOME CARD -->
        <div class="card mb-4 p-4">

            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Dashboard</h1>

                <div class="date-box">
                    <i class='bx bx-calendar'></i>
                    <span id="today-date"></span>
                </div>
            </div>

            <!-- SHORT WELCOME -->
            <p class="text-muted mb-3">
                Welcome to NBUnify HRMS — manage everything in one place.
            </p>

            <!-- ACTIONS -->
            <div class="d-flex gap-2">
                <button class="btn btn-dark" onclick="navTo('companies','nav-master')">
                    <i class='bx bx-buildings'></i> Companies
                </button>

                <button class="btn btn-outline-dark" onclick="navTo('employees','nav-master')">
                    <i class='bx bx-group'></i> Employees
                </button>

                <button class="btn btn-outline-dark" onclick="navTo('reports','nav-reports')">
                    <i class='bx bx-bar-chart'></i> Reports
                </button>
            </div>

        </div>

        <!-- 📊 STATS -->
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <h3>{{ $totalCompanies ?? 0 }}</h3>
                    <p>Total Companies</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <h3>{{ $totalBranches ?? 0 }}</h3>
                    <p>Active Branches</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <h3>{{ $totalEmployees ?? 0 }}</h3>
                    <p>Total Employees</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <h3>{{ $totalDepartments ?? 0 }}</h3>
                    <p>Departments</p>
                </div>
            </div>

        </div>




    </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("today-date").innerText =
                new Date().toLocaleDateString('en-IN', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
        });
    </script>
@endsection


@section('pagejs')

@endsection

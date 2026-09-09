<!-- =========================================================
     DASHBOARD
========================================================= -->

<section
    id="home"
    class="hero card"
    style="padding:24px;"
>

    <div
        class="hero-grid"
        style="
            display:flex;
            gap:20px;
            align-items:center;
        "
    >

        <div
            class="hero-left"
            style="flex:1;"
        >

            <h2>
                Welcome back,
                <?=htmlspecialchars($userName)?>
            </h2>

            <p class="muted">
                Welcome back to the Lipa City Colleges Payroll System,
                Admin—ready to manage your institution's personnel records and oversee payroll operations smoothly and efficiently today.
            </p>

            <div
                class="hero-stats"
                style="
                    display:flex;
                    gap:12px;
                    margin-top:16px;
                "
            >

                <div
                    class="stat card"
                    style="
                        flex:1;
                        text-align:center;
                        padding:16px;
                    "
                >

                    <div
                        class="stat-value"
                        style="
                            font-size:24px;
                            font-weight:bold;
                            color:#0b69ff;
                        "
                    >
                        <?=$deptCount?>
                    </div>

                    <div class="stat-label muted">
                        Departments
                    </div>

                </div>


                <div
                    class="stat card"
                    style="
                        flex:1;
                        text-align:center;
                        padding:16px;
                    "
                >

                    <div
                        class="stat-value"
                        style="
                            font-size:24px;
                            font-weight:bold;
                            color:#0b69ff;
                        "
                    >
                        <?=$posCount?>
                    </div>

                    <div class="stat-label muted">
                        Positions
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

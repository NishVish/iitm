<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Exhibition Operations Checklist</title>
    <style>
        :root {
            --navy: #14335c;
            --navy-light: #1a4d8f;
            --ink: #1f2430;
            --paper: #fbfaf7;
            --line: #dfe2e8;
            --amber: #c17f2a;
            --ok: #2f7a4f;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, "Segoe UI", Arial, sans-serif;
            background: var(--paper);
            color: var(--ink);
            margin: 0;
            padding: 32px 16px 80px;
            line-height: 1.5;
        }

        .wrap {
            max-width: 760px;
            margin: 0 auto;
        }

        header {
            border-bottom: 3px solid var(--navy);
            padding-bottom: 14px;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0 0 4px;
            font-size: 1.5rem;
            color: var(--navy);
            letter-spacing: -0.01em;
        }

        header .meta {
            color: #666;
            font-size: 0.9rem;
        }

        .progress-bar {
            position: sticky;
            top: 0;
            background: var(--paper);
            padding: 10px 0 14px;
            z-index: 10;
            border-bottom: 1px solid var(--line);
            margin-bottom: 12px;
        }

        .progress-track {
            height: 8px;
            background: #eceae3;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: var(--navy-light);
            width: 0%;
            transition: width .25s ease;
        }

        .progress-label {
            font-size: 0.8rem;
            color: #666;
            margin-top: 6px;
            display: flex;
            justify-content: space-between;
        }

        .section {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 8px;
            margin-bottom: 18px;
            overflow: hidden;
        }

        .section>h2 {
            margin: 0;
            background: var(--navy);
            color: #fff;
            font-size: 1.02rem;
            padding: 10px 16px;
            font-weight: 600;
        }

        .section>.subhead {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #fff;
            opacity: 0.75;
            display: block;
            margin-top: 2px;
            font-weight: 400;
        }

        .section-body {
            padding: 6px 16px 14px;
        }

        h3 {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--amber);
            margin: 16px 0 6px;
            border-bottom: 1px dashed var(--line);
            padding-bottom: 4px;
        }

        h3:first-child {
            margin-top: 10px;
        }

        .item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 7px 4px;
            border-radius: 5px;
            cursor: pointer;
        }

        .item:hover {
            background: #f4f2ec;
        }

        .item input[type="checkbox"] {
            margin-top: 3px;
            width: 17px;
            height: 17px;
            accent-color: var(--ok);
            flex-shrink: 0;
            cursor: pointer;
        }

        .item label {
            cursor: pointer;
            flex: 1;
            font-size: 0.95rem;
        }

        .item input:checked~label {
            color: #8b8f96;
            text-decoration: line-through;
        }

        .note {
            font-size: 0.82rem;
            color: #7a5a20;
            background: #fdf3e2;
            border-left: 3px solid var(--amber);
            padding: 6px 10px;
            margin: 6px 0 10px;
            border-radius: 0 4px 4px 0;
        }

        .time {
            font-weight: 600;
            color: var(--navy-light);
        }

        .reset-btn {
            display: inline-block;
            margin-top: 10px;
            font-size: 0.8rem;
            color: #888;
            background: none;
            border: 1px solid var(--line);
            border-radius: 5px;
            padding: 6px 12px;
            cursor: pointer;
        }

        .reset-btn:hover {
            border-color: #999;
            color: #555;
        }

        @media print {

            .progress-bar,
            .reset-btn {
                display: none;
            }

            .section {
                break-inside: avoid;
                border-color: #999;
            }

            body {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="wrap">

        <header>
            <h1>Exhibition Operations Checklist</h1>
            <div class="meta">Pre-Exhibition Date: 08/07/2026</div>
        </header>

        <div class="progress-bar">
            <div class="progress-track">
                <div class="progress-fill" id="fill"></div>
            </div>
            <div class="progress-label"><span id="count">0 / 0 done</span><button class="reset-btn"
                    onclick="resetAll()">Reset all</button></div>
        </div>

        <div class="section">
            <h2>Before Leaving <span class="subhead">Carry &amp; Travel</span></h2>
            <div class="section-body">
                <div class="item"><input type="checkbox" id="c1"><label for="c1">Printed badges — all registered badges
                        printed</label></div>
                <div class="item"><input type="checkbox" id="c2"><label for="c2">Printed certificates — all submitted
                        certificates printed</label></div>
                <div class="item"><input type="checkbox" id="c4"><label for="c4">Travel to venue</label></div>
                <div class="item"><input type="checkbox" id="c5"><label for="c5">At venue — recheck printed items
                        against list</label></div>
            </div>
        </div>

        <div class="section">
            <h2>Pre Exhibition <span class="subhead">08/07/2026</span></h2>
            <div class="section-body">
                <!-- 
                <h3>Material Check</h3>
                <div class="item"><input type="checkbox" id="m1"><label for="m1">Laptop</label></div>
                <div class="item"><input type="checkbox" id="m2"><label for="m2">Printer</label></div>
                <div class="item"><input type="checkbox" id="m3"><label for="m3">Lanyards</label></div>
                <div class="item"><input type="checkbox" id="m4"><label for="m4">Stationery</label></div>
                <div class="item"><input type="checkbox" id="m5"><label for="m5">Badges</label></div>
                <div class="item"><input type="checkbox" id="m6"><label for="m6">Pouches</label></div>
                <div class="item"><input type="checkbox" id="m7"><label for="m7">Exhibitor printed badges</label></div> -->

                <h3>Registration Desk Setup</h3>
                <div class="item"><input type="checkbox" id="r1"><label for="r1">Ask operations team to set up
                        registration desk</label></div>
                <div class="item"><input type="checkbox" id="r2"><label for="r2">Table in place</label></div>
                <div class="item"><input type="checkbox" id="r3"><label for="r3">Chairs in place</label></div>
                <div class="item"><input type="checkbox" id="r4"><label for="r4">Power port available</label></div>
                <div class="item"><input type="checkbox" id="r5"><label for="r5">Fascia installed</label></div>
                <div class="item"><input type="checkbox" id="r6"><label for="r6">Ask operations team to hand over
                        materials</label></div>
                <div class="item"><input type="checkbox" id="r7"><label for="r7">Tally laptop, printer, badge, and
                        material counts</label></div>
                <div class="item"><input type="checkbox" id="r8"><label for="r8">Set up all printers and laptops</label>
                </div>
                <div class="item"><input type="checkbox" id="r9"><label for="r9">Check browser and internet
                        connectivity</label></div>
                <div class="item"><input type="checkbox" id="r10"><label for="r10">Check printer driver and take a test
                        print</label></div>
                <div class="item"><input type="checkbox" id="r11"><label for="r11">Take test print of a spare badge on
                        every system</label></div>
                <div class="item"><input type="checkbox" id="r12"><label for="r12">Print remaining badges</label></div>
                <div class="item"><input type="checkbox" id="r13"><label for="r13">Call volunteers in for screening and
                        briefing</label></div>

                <h3>Volunteer Preparation</h3>
                <div class="item">

                    <input type="checkbox" id="v1"><label for="v1">Volunteer Report at 5oCLock for
                        Reproting</label><input type="checkbox" id="v1"><label for="v1">Volunteer screening
                        completed</label>

                </div>

                <h3>Pre Exhibition Briefing</h3>
                <div class="item"><input type="checkbox" id="b1"><label for="b1">Confirm reporting time</label>
                </div>
                <div class="item"><input type="checkbox" id="b2"><label for="b2">Explain dress code</label></div>
                <div class="item"><input type="checkbox" id="b3"><label for="b3">Divide teams for registration desk
                        and
                        support</label></div>
                <div class="item"><input type="checkbox" id="b4"><label for="b4">Assign a pair of volunteers per
                        system
                        (laptop &amp; printer)</label></div>
                <div class="item"><input type="checkbox" id="b5"><label for="b5">Registration desk handling
                        briefing</label></div>
                <div class="item"><input type="checkbox" id="b6"><label for="b6">Registration desk demo
                        completed</label></div>
                <div class="item"><input type="checkbox" id="b7"><label for="b7">Brief volunteers on exhibitor badge
                        distribution process</label></div>
                <div class="item"><input type="checkbox" id="b8"><label for="b8">Printed certificates
                        arranged</label>
                </div>
                <div class="item"><input type="checkbox" id="b9"><label for="b9">Check every laptop and
                        printer</label>
                </div>
                <div class="item"><input type="checkbox" id="b10"><label for="b10">Confirm all laptops and printers
                        have
                        cables</label></div>
                <div class="item"><input type="checkbox" id="b11"><label for="b11">Confirm good print quality on all
                        paper</label></div>
                <div class="item"><input type="checkbox" id="b12"><label for="b12">4/4 systems working</label></div>
                <div class="item"><input type="checkbox" id="b13"><label for="b13">Print remaining exhibitor
                        badges</label></div>
                <div class="item"><input type="checkbox" id="b14"><label for="b14">Request remaining exhibitor
                        details
                        for badge printing</label></div>
                <div class="item"><input type="checkbox" id="b15"><label for="b15">Printed badges arranged</label>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Live Exhibition</h2>


            <h2>Day:-1</h2>

            <div class="section-body">
                <div class="item"><input type="checkbox" id="l1"><label for="l1">Follow up with volunteers to report
                        at
                        <span class="time">8:30 AM</span></label></div>
                <div class="item"><input type="checkbox" id="l2"><label for="l2">Prepare volunteer attendance sheet
                        immediately after arrival</label></div>

                <h3 style="color:red;">Task:-1</h3>

                <div class="item"><input type="checkbox" id="l3"><label for="l3">Verify tally count of systems and
                        materials</label></div>
                <div class="item"><input type="checkbox" id="l4"><label for="l4">Complete laptop and printer
                        setup</label></div>
                <div class="item"><input type="checkbox" id="l5"><label for="l5">Ensure materials are ready on
                        desks</label></div>


                <div class="item"><input type="checkbox" id="l7"><label for="l7">internet Working on each system
                    </label>
                </div>


                <div class="item"><input type="checkbox" id="l7"><label for="l7">Printer Working on each system
                    </label>
                </div>

                <div class="item"><input type="checkbox" id="l7"><label for="l7">Ready for badge printing</label>
                </div>
                <div class="item"><input type="checkbox" id="l7"><label for="l7">Take Test Print From Each
                        System</label>
                </div>
                <h3 style="color:red;">Task:-2 Take only Exhibitor Request Till 11 AM</h3>

                <div class="item"><input type="checkbox" id="l6"><label for="l6">Have exhibitor
                        Printer Badges</label></div>


                <div class="item"><input type="checkbox" id="l7"><label for="l7">If Person Request for Entry or Badge
                        ask for Business Card then ask for Are you Visiting or Exhibiting</label>
                </div>
                <div class="item"><input type="checkbox" id="l7"><label for="l7">Check on Exhibitor List If entry is
                        there or not</label>
                </div>
                <div class="item"><input type="checkbox" id="l8"><label for="l8">If Entry Found Check if we Pre Prtinted
                        or Not </label></div>
                <div class="item"><input type="checkbox" id="l8"><label for="l8">If Pre Printed Request the Distributor
                        Team</label></div>
                <div class="item"><input type="checkbox" id="l8"><label for="l8">Collect From Distributor
                        Team</label></div>
                <div class="item"><input type="checkbox" id="l8"><label for="l8">Handover the Badge and Mark on
                        Exhibitor List as
                        Collected</label></div>

                <div class="item"><input type="checkbox" id="l8"><label for="l8">Be Ready for Next Request</label></div>

                <h3 style="color:red;">Task:-3 Start Visitor Entry From 11:00 AM</h3>

                <div class="item"><input type="checkbox" id="l6"><label for="l6">Visitor Entry Starts From 11:00
                        AM</label></div>


                <div class="item"><input type="checkbox" id="l8"><label for="l8">Ask For Business Card</div>
                <div class="item"><input type="checkbox" id="l9"><label for="l9">Make Sure this Company and Person are
                        Related to Travel or Hospitatlity</label></div>
                <div class="item"><input type="checkbox" id="l9"><label for="l9">Ask For Registered Mobile
                        Number</label></div>
                <div class="item"><input type="checkbox" id="l9"><label for="l9">If Not Registered Ask them
                        Register</label></div>
                <div class="item"><input type="checkbox" id="l9"><label for="l9">After Registration Search the Number in
                        Badge Station and Print Their Details</label></div>

                <h3 style="color:red;">Task:-4 Go For Lunch Break but Break team and make sure Registation is Never
                    Unattended</h3>




                <h3 style="color:red;">Task:-5 Packup</h3>

                @include('web.documentation.packup')
                <h3>Workflow Inspection</h3>
                <div class="item"><input type="checkbox" id="w1"><label for="w1">All Things Are Shifted to Store
                    </label></div>
            </div>
            <h2>Day:-2</h2>

            @include('web.documentation.starter')

            <h3 style="color:red;">Task:-3 Go For Lunch Break but Break team and make sure Registation is Never
                Unattended</h3>

            <h3 style="color:red;">Task:-4 Packup</h3>

            @include('web.documentation.packup')
            <h3>Workflow Inspection</h3>
            <div class="item"><input type="checkbox" id="w1"><label for="w1">Conduct 1-in-10 inspection check
                    for
                    correct workflow</label></div>
            <h2>Day:-3</h2>

            @include('web.documentation.starter')

            <h3 style="color:red;">Task:-3 Go For Lunch Break but Break team and make sure Registation is Never
                Unattended</h3>

            <h3 style="color:red;">Task:-4 Packup</h3>

            @include('web.documentation.packup')
            <h3>Workflow Inspection</h3>
            <div class="item"><input type="checkbox" id="w1"><label for="w1">Conduct 1-in-10 inspection check
                    for
                    correct workflow</label></div>
        </div>
        <div class="section">
            <h2>Other Responsibilities</h2>
            <div class="section-body">
                <div class="item"><input type="checkbox" id="o1"><label for="o1">Certificate distribution</label>
                </div>
                <div class="item"><input type="checkbox" id="o2"><label for="o2">Water distribution</label></div>
                <div class="item"><input type="checkbox" id="o3"><label for="o3">Card collection</label></div>
                <div class="item"><input type="checkbox" id="o4"><label for="o4">Bag distribution</label></div>
                <div class="item"><input type="checkbox" id="o5"><label for="o5">Feedback form distribution</label>
                </div>
                <div class="item"><input type="checkbox" id="o6"><label for="o6">Feedback form collection</label>
                </div>
            </div>
        </div>

    </div>



    <script>
        const boxes = Array.from(document.querySelectorAll('input[type="checkbox"]'));
        const fill = document.getElementById('fill');
        const count = document.getElementById('count');

        function update() {
            const done = boxes.filter(b => b.checked).length;
            const total = boxes.length;
            fill.style.width = (total ? (done / total * 100) : 0) + '%';
            count.textContent = done + ' / ' + total + ' done';
        }
        function resetAll() {
            if (!confirm('Uncheck all items?')) return;
            boxes.forEach(b => b.checked = false);
            update();
        }
        boxes.forEach(b => b.addEventListener('change', update));
        update();
    </script>
</body>

</html>
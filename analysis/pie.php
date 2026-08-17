<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px;">

    <!-- LEFT DONUT CHART -->
    <div
        style="background: #ffffff; border: 2px solid #cbd5e1; border-radius: 12px; padding: 20px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.03), 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column; align-items: center;">

        <h3
            style="color: #0f766e; font-size: 16px; margin-bottom: 15px; text-align: center; border-bottom: 2px solid #99f6e4; padding-bottom: 6px; width: 100%;">
            📊 Visitor Industry Distribution
        </h3>

        <div style="display: flex; flex-direction: column; align-items: center; gap: 15px; width: 100%;">

            <!-- High Quality Donut Chart -->
            <div style="
                    width: 170px;
                    height: 170px;
                    border-radius: 50%;
                    position: relative;
                    background: conic-gradient(
                        #0f766e 0% 67%,
                        #0284c7 67% 82%,
                        #f59e0b 82% 92%,
                        #6366f1 92% 100%
                    );
                    border: 4px solid #ffffff;
                    box-shadow:
                        0 0 0 2px #cbd5e1,
                        inset 0 0 18px rgba(0,0,0,0.25),
                        0 8px 18px rgba(0,0,0,0.18);
                    overflow:hidden;
                ">

                <!-- Gloss Effect -->
                <div style="
                        position:absolute;
                        inset:0;
                        border-radius:50%;
                        background:radial-gradient(
                            circle at 35% 30%,
                            rgba(255,255,255,0.45),
                            transparent 45%
                        );
                    ">
                </div>

                <!-- Donut Center -->
                <div style="
                        position:absolute;
                        width:75px;
                        height:75px;
                        background:#ffffff;
                        border-radius:50%;
                        top:50%;
                        left:50%;
                        transform:translate(-50%,-50%);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        flex-direction:column;
                        box-shadow:
                            inset 0 2px 8px rgba(0,0,0,0.12),
                            0 2px 8px rgba(0,0,0,0.15);
                    ">
                    <span style="font-size:18px;font-weight:800;color:#0f766e;">
                        67%
                    </span>
                    <span style="font-size:10px;color:#64748b;">
                        Top Segment
                    </span>
                </div>

            </div>


            <?php
            include("visitorlegend.php");
            ?>

        </div>

    </div>


    <?php
    include("bydesignation.php");
    ?>

</div>
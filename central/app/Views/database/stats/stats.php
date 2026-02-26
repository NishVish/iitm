
<main>
    
    <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-top: 5px solid #1abc9c;">
        <h2 style="margin-top: 0; color: #2c3e50;">📊 Operational Intelligence Dashboard</h2>
        <p style="color: #7f8c8d;">Real-time metrics from Centralized SQL Infrastructure</p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 30px 0;">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border-bottom: 4px solid #3498db;">
                <small style="color: #95a5a6; text-transform: uppercase; font-weight: bold;">Total Revenue</small>
                <div style="font-size: 1.5rem; font-weight: bold; color: #2c3e50;">₹<?= number_format($total_revenue, 2) ?></div>
            </div>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border-bottom: 4px solid #1abc9c;">
                <small style="color: #95a5a6; text-transform: uppercase; font-weight: bold;">Conversion Rate</small>
                <div style="font-size: 1.5rem; font-weight: bold; color: #2c3e50;"><?= number_format($conversion_rate, 1) ?>%</div>
            </div>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border-bottom: 4px solid #e67e22;">
                <small style="color: #95a5a6; text-transform: uppercase; font-weight: bold;">Validated Data</small>
                <div style="font-size: 1.5rem; font-weight: bold; color: #2c3e50;"><?= $validated_count ?> <span style="font-size: 0.9rem; color: #95a5a6;">/ <?= $total_companies ?></span></div>
            </div>
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border-bottom: 4px solid #9b59b6;">
                <small style="color: #95a5a6; text-transform: uppercase; font-weight: bold;">30-Day Activity</small>
                <div style="font-size: 1.5rem; font-weight: bold; color: #2c3e50;"><?= $recent_updates ?> Updates</div>
            </div>
        </div>

        <div style="display: flex; gap: 30px; flex-wrap: wrap;">
            
            <div style="flex: 1; min-width: 350px;">
                <h3 style="color: #34495e; border-bottom: 2px solid #eee; padding-bottom: 10px;">📉 Lead Status Funnel</h3>
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px; background: white;">
                    <thead>
                        <tr style="background: #f1f4f6;">
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Status</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($lead_status as $status): ?>
                        <tr>
                            <td style="padding: 12px; border: 1px solid #dee2e6;">
                                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #3498db; margin-right: 8px;"></span>
                                <?= ucfirst($status['status']) ?>
                            </td>
                            <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center; font-weight: bold;"><?= $status['total'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="flex: 1; min-width: 350px;">
                <h3 style="color: #34495e; border-bottom: 2px solid #eee; padding-bottom: 10px;">🏆 Staff Ranking (Companies Assigned)</h3>
                <table style="width: 100%; border-collapse: collapse; margin-top: 10px; background: white;">
                    <thead>
                        <tr style="background: #f1f4f6;">
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: left;">Sales Person</th>
                            <th style="padding: 12px; border: 1px solid #dee2e6; text-align: center;">Managed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($staff_performance as $staff): ?>
                        <tr>
                            <td style="padding: 12px; border: 1px solid #dee2e6; font-weight: 500;"><?= $staff['sales_person'] ?: 'Unassigned' ?></td>
                            <td style="padding: 12px; border: 1px solid #dee2e6; text-align: center; color: #27ae60; font-weight: bold;"><?= $staff['count'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <div style="margin-top: 40px; padding: 20px; background: #ebf5fb; border-radius: 10px; border: 1px solid #d6eaf8;">
            <strong style="color: #2980b9;">Technical Note:</strong> This dashboard is pulling from the <code>company_data</code> and <code>leads</code> tables. Total contacts indexed: <strong><?= $total_contacts ?></strong> across <strong><?= $total_sources ?></strong> acquisition channels.
        </div>
    </div>
</main>
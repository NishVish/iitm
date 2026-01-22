
<?= view('header', ['title' => 'My Website Without Controller']) ?>
  
<?php if (!isset($session)) $session = session(); ?>
<main class="contentArea">
    <div class="sectionContainer">


<section id="communication" class="tab-content active"> 



  <div class="communication-wrapper">
    <div id="event">
      <h2> Temp Announcement</h2>
      <p>Content for Announcement tab goes here.</p>
    </div>
  </div>

  <div class="communication-wrapper">
    <div id="announcement">
      <h2> Temp Announcement</h2>
      <p>Content for Announcement tab goes here.</p>
    </div>
    <br>

    <div id="chat">
      <script>
  const textarea = document.getElementById('commentBox');

  textarea.addEventListener('input', function () {
    this.style.height = 'auto'; // Reset height
    this.style.height = this.scrollHeight + 'px'; // Set height based on scroll
  });
</script>

      <div id="chat-container"></div>
      <?= view('content/chat') ?>
    </div>
  </div>


</section>


    
<section id="employee-book" class="tab-content">
    <h2>Employee Book</h2>
    <div id="employee-table-container">
        <p>Loading employee data...</p>
    </div>
            <!-- Add Employee Modal (included only for admin) -->
      <?php if (session()->get('user_type') === 'admin'): ?>
          <?= view('content/employeebook') ?>
      <?php endif; ?>
</section>


<section id="resource_data_center" class="tab-content">

  <!-- 🔵 Buttons + Search (in one line) -->
  <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
    <!-- Buttons -->
    <a href="#" id="loadHomeViewBtn" style="padding: 6px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;">Home</a>
    <a href="#" id="loadDatabaseViewBtn" style="padding: 6px 12px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px;">Database</a>

    <!-- 🔍 Search bar -->
    <input type="text" id="tableSearch" placeholder="Search..." style="padding: 6px; flex: 1; border: 1px solid #ccc; border-radius: 4px;">
  </div>
  <div id="basicAnalysis">
  total entries
  Total Entries Count By Category
  
  </div>

  <!-- Table -->
  <table id="databasetable" border="1" style="width: 100%; border-collapse: collapse;">
    <thead></thead>
    <tbody></tbody>
  </table>

</section>

    <section id="dashboard" class="tab-content">
<?= view('content/dashboard') ?>
    </section>

<section id="eventover" class="tab-content">
  <h3>Event Dates</h3>
<div class="event-container">
  <div id="year-buttons" style="margin-bottom: 1em;"></div>
  <div id="event-cards" class="card-container"></div>
</div>

  </section>


      <section id="hr" class="tab-content">
        <?= view('content/hr.php') ?>
    </section>

      <section id="tools" class="tab-content">
        <?= view('content/tools') ?>
    </section>

          <section id="creative" class="tab-content">
            <div id="creative-messages">
      <!-- You can optionally render some initial messages here -->
    </div>
    
    <?= view('content/creative')?>
    <!--  -->
  </section>

</div>
</main>

<?= view('footer') ?>








<?php if (!isset($session)) $session = session(); ?>

<?php
$tabs = [
    'communication'   => 'Communication',
    'employee-book'  => 'Employee Book',
    'resource_data_center'      => 'Resource & Data Center',
    'dashboard'      => 'Dashboard',
    'eventover'    => 'Event Overview',
    'tools'           => 'Tools',
    'hr'           => 'HR Department',
        'creative'           => 'Creative/Design',

    
];

$userType = $session->get('user_type');
// $cat = $session->get('user_type');

// Admin gets all tabs
if ($userType === 'admin' || $userType === 'hr' ) {
    $availableTabs = array_keys($tabs);

}
// Staff gets limited tabs
elseif ($userType === 'general') {
    $availableTabs = ['communication', 'employee-book','resource_data_center', 'dashboard','tools'];
}
// Viewer gets minimal tabs
else {
    $availableTabs = ['communication','tools','creative'];
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= esc($title ?? 'Admin Panel') ?></title>

<link rel="stylesheet" href="<?= base_url('public/css/home.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/tools.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/chat.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/communication.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/creative.css') ?>">
<link rel="stylesheet" href="<?= base_url('public/css/event.css') ?>">


</head>
<body>



    <div style="float: right; padding: 10px; color:orange;">
        <strong><?= esc($session->get('username')) ?> <a href="<?= base_url('logout') ?>" style="color:orange;">Logout</a></strong>
    </div>
    <header>
        <div class="centercc" style="height:65px; ">
  <div class="center-container" style="
  position: fixed;
  top: 8%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: inline-block;
  cursor: pointer;
  overflow: visible; /* show pulse outside container */
">
  <div id="pulse-wave" style="
    position: fixed;
    top: calc(5% + px); /* logo top (0%) + half logo height (0px/2) */
    left: 50%;
    height: 50px;
    width: 0;
    background: rgba(255, 255, 0, 0.5);
    border-radius: 250px;
    transform: translateX(-50%);
    pointer-events: none;
    opacity: 0;
    z-index: 1000;
  "></div>
  <img 
    id="logo" 
    src="https://spheretravelmedia.com/wp-content/uploads/2025/03/cropped-cropped-38x38inch-Sphere-Logo-Copy-min_prev_ui-300x100.png" 
    alt="Company Logo" 
    style="height: 50px; width: auto; position: relative; z-index: 1010;" 
  />
</div>
<script>
  const centerContainer = document.querySelector('.center-container');

  window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    // Calculate opacity: 1 at scrollTop=0, 0 at scrollTop=40 or more
    let opacity = 1 - scrollTop / 40;
    if (opacity < 0) opacity = 0;
    if (opacity > 1) opacity = 1;

    centerContainer.style.opacity = opacity;
    centerContainer.style.pointerEvents = opacity === 0 ? 'none' : 'auto';
  });
</script>

<style>
  @keyframes expandPulse {
    0% {
      width: 0;
      opacity: 0.7;
    }
    100% {
      width: 100vw;  /* full viewport width */
      opacity: 0;
    }
  }
</style>

<script>
  const pulse = document.getElementById('pulse-wave');
  const logo = document.getElementById('logo');

  logo.addEventListener('click', () => {
    pulse.style.animation = 'none';  // reset animation
    pulse.offsetHeight;               // trigger reflow
    pulse.style.opacity = '0.7';
    pulse.style.animation = 'expandPulse 0.8s forwards ease-out';
  });

  pulse.addEventListener('animationend', () => {
    pulse.style.opacity = '0';
    pulse.style.width = '0';
    pulse.style.animation = 'none';
  });
</script>


</div>



        <div class="tabs" role="tablist">
    <?php $first = true; ?>

    <?php foreach ($availableTabs as $tabKey): ?>
        <button class="tab-button <?= $first ? 'active' : '' ?>" data-tab="<?= esc($tabKey) ?>">
            <?= esc($tabs[$tabKey]) ?>
        </button>
        <?php $first = false; ?>
    <?php endforeach; ?>
    </div>
</div>


    </header>


    <script>

      window.addEventListener('DOMContentLoaded', () => {
  // Simulate tab click on page load for "announcement"
  const defaultTab = document.querySelector('.tab-button[data-tab="communication"]');
  if (defaultTab) defaultTab.click();
});



window.addEventListener('DOMContentLoaded', () => {

  function activateTab(tab) {
    // Remove active class from all buttons and tab contents
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(section => section.classList.remove('active'));

    // Add active class to current tab button and content
    const activeBtn = document.querySelector(`.tab-button[data-tab="${tab}"]`);
    const activeContent = document.getElementById(tab);

    if (activeBtn) activeBtn.classList.add('active');
    if (activeContent) activeContent.classList.add('active');
 // Call loading functions depending on tab
    switch(tab) {
      case 'communication':
        loadAnnouncements();
        loadEvent();
        //loadChats();
        break;
      case 'employee-book':
        loadEmployeeBook();
        break;
      case 'creative':
        loadCreativeMessages();
        // loadDepartments();
        break;
      case 'eventover':
        loadEventOverview();
        break;
      case 'resource_data_center':
        loadResourceDataCenter();
        break;
      // add more tabs here
      default:
        console.warn('No load function for tab:', tab);
    }
  }

  // Attach click listeners to all tab buttons
  document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', () => {
      const tab = button.getAttribute('data-tab');
      activateTab(tab);
    });
  });

  // Activate default tab on page load
  activateTab('communication');

});


function loadAnnouncements() {
   fetch('fetch-announcements', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(response => {
        if (!response.ok) throw new Error(`Network error: ${response.status}`);
        return response.json();
      })
      .then(data => {
        console.log('Announcements:', data);
        const container = document.getElementById('announcement');
        if (data.length === 0) {
          container.innerHTML = '<p>No announcements found.</p>';
          return;
        }
        let html = `<h2 style="text-align:center;">Announcement</h2><table>
          <thead><tr>
            <th>Date</th><th>Info</th>
          </tr></thead><tbody>`;
        data.forEach(a => {
          html += `<tr>
            <td>${a.date} <br>
            ${a.topic}<br>${a.department}
            </td>
            <td>${a.info}</td>
          </tr>`;
        });
        html += '</tbody></table>';
        container.innerHTML = html;
      })
      .catch(err => {
        console.error('Announcement Fetch error:', err);
        document.getElementById('announcement').innerHTML += '<p>Error loading announcements.</p>';
      });

  fetch('fetch-chats', {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(res => {
    if (!res.ok) throw new Error(`Network error: ${res.status}`);
    return res.json();
  })
  .then(data => {
    console.log('Chat Data:', data);
    const container = document.getElementById('chat-container');
    if (data.length === 0) {
      container.innerHTML = '<p>No chat messages found.</p>';
      return;
    }
    let html = '';

data.forEach(chat => {
  html += `
    <div class="chat-message">
      <div class="chat-header">
        <span class="chat-user">${chat.name}</span>
        <span class="chat-time">${new Date(chat.time).toLocaleString()}</span>
      </div>
      <div class="chat-comment">${chat.comment}</div>
    </div>
  `;
});

container.innerHTML = html;


  })
  .catch(err => {
    console.error('Chat Fetch error:', err);
    document.getElementById('chat').innerHTML += '<p>Error loading chat data.</p>';
  });
}


function loadResourceDataCenter() {
  fetch('resource_data_center', {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(res => {
    if (!res.ok) throw new Error(`Network error: ${res.status}`);
    return res.json();
  })
  .then(data => {
    console.log('Employee Data:', data);

    const table = document.getElementById('databasetable');
    const thead = table.querySelector('thead');
    const tbody = table.querySelector('tbody');

    // Clear any existing content
    thead.innerHTML = '';
    tbody.innerHTML = '';

    if (data.length === 0) {
      thead.innerHTML = '<tr><th>No Data</th></tr>';
      return;
    }

    // 1. Dynamically generate table headers
    const headers = Object.keys(data[0]);
    const headerRow = document.createElement('tr');
    headers.forEach(key => {
      const th = document.createElement('th');
      th.textContent = key;
      headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);

    // 2. Generate table rows
    data.forEach(row => {
      const tr = document.createElement('tr');
      headers.forEach(key => {
        const td = document.createElement('td');
        td.textContent = row[key] !== null ? row[key] : ''; // Handle null values
        tr.appendChild(td);
      });
      tbody.appendChild(tr);
    });
  })
  .catch(err => {
    console.error('Fetch error:', err);
    document.getElementById('resourceContainer').innerHTML = `<p style="color:red;">Error loading data: ${err.message}</p>`;
  });
}
// 
// 
// 
// 
function loadEvent() {
  fetch('event_details', {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    console.log('✅ Events loaded:', data);
    
    const eventSection = document.getElementById('event');
    eventSection.innerHTML = '<h3>Event Dates</h3>';  // Reset content and keep heading
    
    if (!data || data.length === 0) {
      eventSection.innerHTML += '<p>No events found.</p>';
      return;
    }
    
    // Create table element
    const table = document.createElement('table');
    table.border = "1";
    table.style.width = "100%";
    table.style.borderCollapse = "collapse";
    
    // Create table head
    const thead = document.createElement('thead');
    thead.innerHTML = `
  <tr>
    <th>Name</th>
    <th>Year</th>
    <th>Location</th>
    <th>Timing</th>
    <th>Day 1</th>
    <th>Day 2</th>
    <th>Day 3</th>
    <th>Card Received</th>
    <th>Card Typing</th>
    <th>Validation</th>
    <th>Merging with Database</th>
    <th>Putting in Folder</th>
  </tr>
`;

    table.appendChild(thead);
    
    // Create table body
    const tbody = document.createElement('tbody');
    
data.forEach(event => {
  const row = document.createElement('tr');
  row.innerHTML = `
    <td>${event.name || 'N/A'}</td>
    <td>${event.year || 'N/A'}</td>
    <td>${event.location || 'N/A'}</td>
        <!--     <td>${event.multiple_days ? 'Yes' : 'No'}</td> -->
    <td>${event.timing || 'N/A'}</td>
    <td>${event.day1 || '-'}</td>
    <td>${event.day2 || '-'}</td>
    <td>${event.day3 || '-'}</td>
    <td>${event.card_received || 'N/A'}</td>
    <td>${event.card_typing || 'N/A'}</td>
    <td>${event.validation || 'N/A'}</td>
    <td>${event.merging_with_database || 'N/A'}</td>
    <td>${event.putting_in_folder || 'N/A'}</td>
  `;
  tbody.appendChild(row);
});

    
    table.appendChild(tbody);
    
    // Append the table inside the section
    eventSection.appendChild(table);
  })
  .catch(error => {
    console.error('❌ Error loading events:', error);
  });
}


// function loadEventOverview() {
//       console.log('✅ loadEventOverview loaded:');

//   fetch('event_details', {
//     method: 'GET',
//     headers: {
//       'X-Requested-With': 'XMLHttpRequest'
//     }
//   })
//   .then(response => {
//     if (!response.ok) {
//       throw new Error('Network response was not ok');
//     }
//     return response.json();
//   })
//   .then(data => {
//     console.log('✅ Events loaded:', data);
    
//     const eventSection = document.getElementById('eventover');
//     eventSection.innerHTML = '<h3>Event Dates</h3>';  // Reset content and keep heading
//         console.log(eventSection);

//     if (!data || data.length === 0) {
//       eventSection.innerHTML += '<p>No events found.</p>';
//       return;
//     }
    
//     // Create table element
//     const table = document.createElement('table');
//     table.border = "1";
//     table.style.width = "100%";
//     table.style.borderCollapse = "collapse";
    
//     // Create table head
//     const thead = document.createElement('thead');
//     thead.innerHTML = `
//   <tr>
//     <th>Name</th>
//     <th>Year</th>
//     <th>Location</th>
//     <th>Timing</th>
//     <th>Day 1</th>
//     <th>Day 2</th>
//     <th>Day 3</th>
//     <th>Card Received</th>
//     <th>Card Typing</th>
//     <th>Validation</th>
//     <th>Merging with Database</th>
//     <th>Putting in Folder</th>
//   </tr>
// `;

//     table.appendChild(thead);
    
//     // Create table body
//     const tbody = document.createElement('tbody');
    
// data.forEach(event => {
//   const row = document.createElement('tr');
//   row.innerHTML = `
//     <td>${event.name || 'N/A'}</td>
//     <td>${event.year || 'N/A'}</td>
//     <td>${event.location || 'N/A'}</td>
//         <!--     <td>${event.multiple_days ? 'Yes' : 'No'}</td> -->


//     <td>${event.timing || 'N/A'}</td>
//     <td>${event.day1 || '-'}</td>
//     <td>${event.day2 || '-'}</td>
//     <td>${event.day3 || '-'}</td>
//     <td>${event.card_received || 'N/A'}</td>
//     <td>${event.card_typing || 'N/A'}</td>
//     <td>${event.validation || 'N/A'}</td>
//     <td>${event.merging_with_database || 'N/A'}</td>
//     <td>${event.putting_in_folder || 'N/A'}</td>
//   `;
//   tbody.appendChild(row);
// });

    
//     table.appendChild(tbody);
    
//     // Append the table inside the section
//     eventSection.appendChild(table);
//   })
//   .catch(error => {
//     console.error('❌ Error loading events:', error);
//   });
// }

function loadEventOverview() {
  console.log('✅ loadEventOverview loaded:');
  
  fetch('event_details', {
    method: 'GET',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    console.log('✅ Events loaded:', data);

    const eventSection = document.getElementById('eventover');
    const yearButtonsContainer = document.getElementById('year-buttons');
    const cardContainer = document.getElementById('event-cards');

    eventSection.querySelector('h3').textContent = "Event Dates";
    yearButtonsContainer.innerHTML = '';
    cardContainer.innerHTML = '';

    if (!data || data.length === 0) {
      cardContainer.innerHTML = '<p>No events found.</p>';
      return;
    }

    // ✅ Get unique years
    const uniqueYears = [...new Set(data.map(event => event.year))].sort().reverse();

    // ✅ Create a button for each year
    uniqueYears.forEach(year => {
      const button = document.createElement('button');
      button.textContent = year;
      button.style.marginRight = '8px';
      button.className = 'year-button';
      button.onclick = () => renderCards(data.filter(ev => ev.year === year), year);
      yearButtonsContainer.appendChild(button);
    });

    // ✅ Default: show most recent year
    if (uniqueYears.length > 0) {
      renderCards(data.filter(ev => ev.year === uniqueYears[0]), uniqueYears[0]);
    }
  })
  .catch(error => {
    console.error('❌ Error loading events:', error);
  });
}

function renderCards(events, year) {
  const cardContainer = document.getElementById('event-cards');
  cardContainer.innerHTML = `<h4>Showing Events for Year: ${year}</h4>`;

  if (events.length === 0) {
    cardContainer.innerHTML += '<p>No events found for this year.</p>';
    return;
  }
  
  
  
  events.forEach(event => {
  const card = document.createElement('div');
  card.className = 'event-card';
  card.innerHTML = `
    <h5>${event.name || 'N/A'}</h5>
    <table style="width: 100%;">
      <tr>
        <td style="width: 25%; vertical-align: top; padding-right: 10px;">
          <p><strong>Venue Address:</strong> ${event.venue_address || 'N/A'}</p>
          <p><strong>Area:</strong> ${event.area || 'N/A'}</p>
          <p><strong>Hall/Building:</strong> ${event.hall_building || 'N/A'}</p>
          
                    <p><strong>Initial Layout:</strong> ${event.initial_layout || 'N/A'}</p>
          <p><strong>Final Layout:</strong> ${event.final_layout || 'N/A'}</p>

                    <p><strong>Bill:</strong> ${event.bill || 'N/A'}</p>
                    
          
          </td>
        <td style="width: 25%; vertical-align: top; padding-left: 10px;">
           <p><strong>Timing:</strong> ${event.timing || 'N/A'}</p>
        <p><strong>Day 1:</strong> ${event.day1 || '-'}</p>
          <p><strong>Day 2:</strong> ${event.day2 || '-'}</p>
          <p><strong>Day 3:</strong> ${event.day3 || '-'}</p>
          
          <p><strong>Comment:</strong> ${event.comment || 'N/A'}</p>
          <p><strong>Vendor Details:</strong> ${event.comment || 'N/A'}</p>
        </td>

        <td style="width: 25%; vertical-align: top; padding-left: 10px;">
        <p><strong>Card Typing:</strong> ${event.card_typing ? 'Yes' : 'No'}</p>
          <p><strong>Validation:</strong> ${event.validation ? 'Yes' : 'No'}</p>
          <p><strong>Merging with Database:</strong> ${event.merging_with_database ? 'Yes' : 'No'}</p>
          <p><strong>Putting in Folder:</strong> ${event.putting_in_folder ? 'Yes' : 'No'}</p>
          <p><strong>View Event Logs:</strong> ${event.putting_in_folder ? 'Yes' : 'No'}</p>
          
        </td>

                <td style="width: 25%; vertical-align: top; padding-left: 10px;">
        <p><strong>Total Seller:</strong> ${event.card_typing ? 'Yes' : 'No'}</p>
          <p><strong>Total Visitor:</strong> ${event.validation ? 'Yes' : 'No'}</p>
          <p><strong>New Company:</strong> ${event.merging_with_database ? 'Yes' : 'No'}</p>
          <p><strong>Comparison to Previous Year:</strong> ${event.putting_in_folder ? 'Yes' : 'No'}</p>
          
        </td>
      </tr>
    </table>
  `;
  cardContainer.appendChild(card);
});



}



function loadCreativeMessages() {
  fetch('creative', {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
  .then(res => {
    if (!res.ok) throw new Error(`Network error: ${res.status}`);
    return res.json();
  })
  .then(data => {
    const container = document.getElementById('creative-messages');
if (!data.messages || data.messages.length === 0) {
  container.innerHTML = '<p>No creative messages found.</p>';
  return;
}


let html = '';
data.messages.forEach(msg => {
  const imageUrl = `/sphereintranet/public/uploads/${msg.image_url}`;
  html += `

<style>
.image-container {
  position: relative;
  display: inline-block;
  width: 100%;
  max-width: 300px;
  overflow: hidden;
  border-radius: 8px;
}

.image-container img {
  width: 100%;
  height: auto;
  display: block;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

/* Overlay click zones */
.image-container .half-link {
  position: absolute;
  top: 0;
  bottom: 0;
  width: 50%;
  z-index: 2;
}

.image-container .preview-link {
  left: 0;
}

.image-container .download-link {
  right: 0;
}

/* Optional hover overlay for visual feedback */
.image-container .half-link:hover::before {
  content: attr(data-label);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  font-size: 0.9rem;
  background: rgba(0, 0, 0, 0.5);
  padding: 4px 10px;
  border-radius: 4px;
}
</style>

 <div class="message ${msg.sender}" style="margin-bottom: 1rem; max-width: 300px;">
    <div class="meta" style="font-size: 0.85rem; color: #666; margin-bottom: 0.25rem;">
      <span class="department">${msg.department}</span> | 
      <span class="timestamp">${msg.created_at}</span>
    </div>

    <div class="image-container">
      <img src="${imageUrl}" alt="Image" />

      <!-- Left: Preview -->
      <a href="${imageUrl}" target="_blank" class="half-link preview-link" data-label="Preview"></a>

      <!-- Right: Download -->
      <a href="${imageUrl}" download class="half-link download-link" data-label="Download"></a>
    </div>

    <div class="text" style="margin-top: 0.5rem;">${msg.message}</div>
  </div>
`;
});



container.innerHTML = html;

  })
  .catch(err => {
    console.error('Creative Messages Fetch error:', err);
const container = document.getElementById('creative-messages');
    container.innerHTML += '<p>Error loading creative messages.</p>';
  });


  fetch('creative/fetchDepartmentList')
  .then(res => res.json())
  .then(departments => {
    const deptSelect = document.getElementById('department-select');
    deptSelect.innerHTML = '<option value="">Select Department</option>';

    departments.forEach(dept => {
      if(dept) {  // skip empty/null values
        const option = document.createElement('option');
        option.value = dept;
        option.textContent = dept;
        deptSelect.appendChild(option);
      }
    });
  });
}





    
function loadEmployeeBook() {//     if (tab === 'employee-book') {
      fetch('fetch-employee-book', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(res => {
        if (!res.ok) throw new Error(`Network error: ${res.status}`);
        return res.json();
      })
      .then(data => {
        console.log('Employee Data:', data);
        const container = document.getElementById('employee-book');
        if (data.length === 0) {
          container.innerHTML = '<p>No employee records found.</p>';
          return;
        }
        let html = `<table>
          <thead><tr>
            <th>Name</th><th>Phone</th><th>Email</th>
          </tr></thead><tbody>`;
        data.forEach(emp => {
          html += `<tr>
      
            <td>${emp.name}</td>
            <td>${emp.phone}</td>
            <td>${emp.email}</td>
          </tr>`;
        });
html += '</tbody></table>';

    // Replace the "Loading..." text with the actual table
    document.getElementById('employee-table-container').innerHTML = html;
      })
      .catch(err => {
        console.error('Employee Book Fetch error:', err);
        document.getElementById('employee-book').innerHTML += '<p>Error loading employee data.</p>';
      });

    }






// Similarly create loadChats, loadEmployeeBook, loadCreativeMessages, loadDepartments, loadResourceDataCenter functions




document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('chat-form');
  const input = form.querySelector('input[name="comment"]');

  form.addEventListener('submit', e => {
    e.preventDefault(); // Prevent default submit

    const comment = input.value.trim();
    if (!comment) return;

    fetch(form.action, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest', // Must be exactly this for isAJAX() check
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: new URLSearchParams({ comment })
    })
    .then(res => {
      if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
      return res.json();
    })
    .then(data => {
      if (data.success) {
        input.value = ''; // Clear input on success
        console.log('Message sent!');
        // Optionally refresh chat messages here
      } else if (data.error) {
        console.error('Error:', data.error);
      }
    })
    .catch(err => {
      console.error('Fetch error:', err);
    });
  });
});

</script>


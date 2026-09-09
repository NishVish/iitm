import os

# ==============================
# Get module name
# ==============================

name = input("Enter module name: ").strip()

if not name:
    print("Module name cannot be empty.")
    exit()

# Format names
name = name[0].upper() + name[1:]
name_lower = name.lower()


# ==============================
# CONTROLLER
# ==============================

controller_dir = os.path.join(
    "app",
    "Http",
    "Controllers",
    name
)

controller_file = os.path.join(
    controller_dir,
    f"{name}Controller.php"
)

# Create controller folder
os.makedirs(controller_dir, exist_ok=True)

# Controller content
controller_content = f"""<?php

namespace App\\Http\\Controllers\\{name};

use App\\Http\\Controllers\\Controller;
use Illuminate\\Http\\Request;

use App\\Models\\BookingDetail;
use App\\Models\\EventDetail;
use App\\Models\\CompanyDetail;
use App\\Models\\DelegateAttending;
use Illuminate\\Support\\Facades\\DB;

class {name}Controller extends Controller
{{
    
}}
"""

# Create controller file
with open(controller_file, "w", encoding="utf-8") as file:
    file.write(controller_content)


# ==============================
# ROUTE
# ==============================

route_dir = os.path.join(
    "routes",
    name_lower
)

route_file = os.path.join(
    route_dir,
    f"{name_lower}.php"
)

# Create route folder
os.makedirs(route_dir, exist_ok=True)

# Route content
route_content = f"""<?php

use App\\Http\\Controllers\\{name}\\{name}Controller;
use Illuminate\\Support\\Facades\\Route;


// Add {name} routes here


"""

# Create route file
with open(route_file, "w", encoding="utf-8") as file:
    file.write(route_content)


# ==============================
# ADD ROUTE TO web.php
# ==============================

web_file = os.path.join(
    "routes",
    "web.php"
)

require_line = (
    f"require __DIR__ . '/{name_lower}/{name_lower}.php';"
)

if not os.path.exists(web_file):
    print("ERROR: routes/web.php does not exist.")
    exit()

# Read web.php
with open(web_file, "r", encoding="utf-8") as file:
    web_content = file.read()

# Prevent duplicate require
if require_line not in web_content:

    with open(web_file, "a", encoding="utf-8") as file:
        file.write("\n" + require_line + "\n")

    print(f"Added to web.php:")
    print(require_line)

else:
    print("Require statement already exists in web.php.")


# ==============================
# DONE
# ==============================

print()
print("================================")
print("Module created successfully!")
print("================================")

print(f"Controller:")
print(f"  {controller_file}")

print()

print(f"Route:")
print(f"  {route_file}")

print()

print("web.php:")
print(f"  {require_line}")
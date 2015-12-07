# Init script for Root Tongue site

echo "Commencing WordPress latest stable Setup"

# Make a database, if we don't already have one
echo "Creating database (if it's not already there)"
mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS root_tongue_wp"

# Check for the presence of a `core` folder.
if [ ! -d core/wp-admin ]
then
    echo "Checking out WordPress SVN"
    # If `core` folder doesn't exist, check out WordPress
    # as that folder
    svn checkout http://svn.automattic.com/wordpress/trunk/ core
    # Change into the `core` folder we've checked SVN out into
    cd core
    # Use WP CLI to install WordPress
    wp core install --url=root-tongue.dev --title="Root Tongue Dev" --admin_user=admin --admin_password=abc --admin_email=demo@example.com --allow-root
    # Change folder to the parent folder of `core`
    cd ..
else
    echo "Updating WordPress SVN"
    # If the `core` folder exists, then run SVN update
    svn up core
fi

# The Vagrant site setup script will restart Nginx for us

# Let the user know the good news
echo "Latest stable WordPress now installed at http://root-tongue.dev";

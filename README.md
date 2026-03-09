# Registry

Registry is a document management system that helps you organize and track your important documents. Whether it's letters, contracts, or receipts - keep everything in one place.

## Features

- **File Uploads** - Upload any type of file (PDF, images, documents)
- **Quick Search** - Find any document instantly by title, reference number, or description
- **CSV Export** - Download all your registry data as a CSV file for reports
- **User Authentication** - Secure login system to keep your documents private

## Tech Stack

- **Backend**: Laravel 12 (PHP)
- **Database**: SQLite (easy to set up, no configuration needed)
- **Frontend**: Tailwind CSS
- **Icons**: Solar Icons

## Installation

```bash
# Clone the repo
git clone https://github.com/your-username/registry.git
cd registry

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Set up the database
php artisan migrate

# Start the development server
php artisan serve
```

Now open `http://localhost:8000` in your browser.

## Usage

1. Register a new account or log in
2. Click "New Registry" to add a document
3. Fill in the reference number, title, and description
4. Upload your file
5. Use the search bar to find documents anytime
6. Export your data to CSV for reports

## Screenshot

![Registry](https://user-images.githubusercontent.com/YOUR_USERNAME/YOUR_REPO/screenshot.png)

## License

MIT

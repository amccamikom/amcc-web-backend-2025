#!/bin/bash

# 🚀 Setup Script untuk API Documentation Demo

echo "================================================"
echo "🚀 Setting Up API Documentation Project"
echo "================================================"

# 1. Generate API documentation
echo ""
echo "📚 Generating API Documentation..."
php artisan scribe:generate

# 2. Create fresh database and seed data
echo ""
echo "🗄️  Setting up Database..."
php artisan migrate:fresh --seed

echo ""
echo "================================================"
echo "✅ Setup Complete!"
echo "================================================"
echo ""
echo "📍 Important URLs:"
echo "   • API Docs (Web): http://localhost:8000/docs"
echo "   • Postman Collection: http://localhost:8000/postman/collection"
echo "   • OpenAPI Spec: http://localhost:8000/postman/openapi"
echo ""
echo "🧪 Test Credentials:"
echo "   • Email: john@example.com"
echo "   • Password: password"
echo ""
echo "📖 Next Steps:"
echo "   1. Start server: php artisan serve"
echo "   2. Visit: http://localhost:8000/docs"
echo "   3. Download Postman Collection from /postman/collection"
echo ""

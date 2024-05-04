import React from 'react';
import Header from './Components/Header';

function App() {
  return (
    <div className="flex flex-col min-h-screen bg-gray-100">
      {/* Header Section */}
      <Header />
      {/* Main Content Section */}
      <main className="flex-grow container mx-auto p-6">
        <section id="products" className="text-center">
          <h2 className="text-3xl font-bold mb-4">Featured Product</h2>
          <div className="bg-white rounded shadow p-6 max-w-md mx-auto">
            <img
              src="/images/product-placeholder.webp"
              alt="Example Product"
              className="w-full h-auto mb-4"
            />
            <h3 className="text-xl font-semibold">Product Name</h3>
            <p className="text-gray-600 mt-2">Description of the product goes here. Price: $XX.XX</p>
          </div>
        </section>
      </main>

      {/* Footer Section */}
      <footer className="bg-white shadow p-4">
        <div className="container mx-auto text-center">
          <p>&copy; 2024 My Webshop. All rights reserved.</p>
        </div>
      </footer>
    </div>
  );
}

export default App;
<?php
namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\Posts_model;

class Search extends Controller
{ 
    public function index()
    {
        $keyword = $this->request->getPost('searchInput');
        $data['posts'] = $this->getSearchResult($keyword); 

        echo view('template/header');
        echo view('search_results', $data);
        echo view('template/footer');
    }

    public function getSearchResult($keyword)
    {
        $this->$keyword = $keyword;
        $model = new Posts_model();
        return $model->searchPosts($keyword);
    }

    public function submitSearch()
    {
        $keyword = $this->request->getPost('searchInput');
        $model = new Posts_model();
        
        // Fetch the data from the database based on the keyword
        $data = $model->searchPosts($keyword); // Replace 'your_model' with your actual model name and 'searchData' with your method to fetch data
    
        // Return the data as a JSON response
        return $this->response->setJSON(['data' => $data]);
    }

    public function autoSuggestions()
    {
        $keyword = $this->request->getPost('keyword');        
        
        $model = new Posts_model();
        $data = $model->searchPosts($keyword);
        // Return the data as a JSON response
        return $this->response->setJSON(['data' => $data]);
    }
    
}

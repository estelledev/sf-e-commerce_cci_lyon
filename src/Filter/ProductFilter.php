<?php

namespace App\Filter;

class ProductFilter
{
    public function __construct(
        private int $page = 1,
        private ?string $query = null,
        private ?int $min = null,
        private ?int $max = null,
        private ?string $sort = null,
        private string $order = 'ASC',
        private array $tags = [],
    )
    {
        
    }

        /**
         * Get the value of page
         */ 
        public function getPage()
        {
                return $this->page;
        }

        /**
         * Set the value of page
         *
         * @return  self
         */ 
        public function setPage($page)
        {
                $this->page = $page;

                return $this;
        }

        /**
         * Get the value of query
         */ 
        public function getQuery()
        {
                return $this->query;
        }

        /**
         * Set the value of query
         *
         * @return  self
         */ 
        public function setQuery($query)
        {
                $this->query = $query;

                return $this;
        }

        /**
         * Get the value of min
         */ 
        public function getMin()
        {
                return $this->min;
        }

        /**
         * Set the value of min
         *
         * @return  self
         */ 
        public function setMin($min)
        {
                $this->min = $min;

                return $this;
        }

        /**
         * Get the value of max
         */ 
        public function getMax()
        {
                return $this->max;
        }

        /**
         * Set the value of max
         *
         * @return  self
         */ 
        public function setMax($max)
        {
                $this->max = $max;

                return $this;
        }

        /**
         * Get the value of sort
         */ 
        public function getSort()
        {
                return $this->sort;
        }

        /**
         * Set the value of sort
         *
         * @return  self
         */ 
        public function setSort($sort)
        {
                $this->sort = $sort;

                return $this;
        }

        /**
         * Get the value of order
         */ 
        public function getOrder()
        {
                return $this->order;
        }

        /**
         * Set the value of order
         *
         * @return  self
         */ 
        public function setOrder($order)
        {
                $this->order = $order;

                return $this;
        }

        /**
         * Get the value of tags
         */ 
        public function getTags()
        {
                return $this->tags;
        }

        /**
         * Set the value of tags
         *
         * @return  self
         */ 
        public function setTags($tags)
        {
                $this->tags = $tags;

                return $this;
        }
}
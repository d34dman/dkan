How to add a Dataset
====================

.. _guide_dataset:

There are several methods for adding datasets to your site.

API
---
You will need to authenticate with a user account possessing the 'api user' role. Use *Basic Auth*.

Run a POST command to ``/api/1/metastore/schemas/dataset/items`` with a json formatted request body, the minimal elements are:


.. code-block::

    POST http://dkan.ddev.site/api/1/metastore/schemas/dataset/items?format_json HTTP/1.1
    content-type: application/json
    Authorization: Basic admin:admin

        {
          "title": "My new dataset",
          "description": "Description for my new dataset.",
          "accessLevel": "public",
          "modified": "2020-02-02",
          "keyword": [
            "test"
          ]
        }


GUI
----

1. Log in to the site.
2. Navigate to Admin > DKAN > Datasets.
3. Click the "+ Add new dataset" button.
4. Use the Distribution *Download URL* field to enter a url to your file or upload a local file.
5. Fill in the form with as much descriptive information as you can to make it discoverable.
6. Click "submit".
7. Run cron to start the import.


Harvest
-------
If you just need a sample dataset for local development or want to test the harvest process, create a json file in your local sites/default/files directory like this:

*h1.json*

.. code-block:: json

      {
        "@context": "https:\/\/project-open-data.cio.gov\/v1.1\/schema\/catalog.jsonld",
        "@id": "http:\/\/fake.com\/data.json",
        "@type": "dcat:Catalog",
        "conformsTo": "https:\/\/project-open-data.cio.gov\/v1.1\/schema",
        "describedBy": "https:\/\/project-open-data.cio.gov\/v1.1\/schema\/catalog.json",
        "dataset": [
          {
            "@type": "dcat:Dataset",
            "accessLevel": "public",
            "contactPoint": {
              "fn": "admin",
              "hasEmail": "test@test.com"
            },
            "description": "Test description",
            "distribution": [
              {
                "@type": "dcat:Distribution",
                "downloadURL": "http://demo.getdkan.org/sites/default/files/distribution/cedcd327-4e5d-43f9-8eb1-c11850fa7c55/Bike_Lane.csv",
                "mediaType": "text\/csv",
                "format": "csv",
                "title": "Test Resource"
              }
            ],
            "identifier": "cedcd327-4e5d-43f9-8eb1-c11850fa7c66",
            "issued": "2016-06-22",
            "modified": "2020-08-12",
            "publisher": {
              "@type": "org:Organization",
              "name": "demo.getdkan.com"
            },
            "theme": [
              "Test"
            ],
            "title": "New Dataset",
            "keyword": [
              "tag-1"
            ]
          }
        ]
      }


Create a harvest based on the file above:

.. code-block::

      dktl drush dkan:harvest:register --identifier=data --extract-uri=http://dkan.ddev.site/sites/default/files/h1.json
      dktl drush dkan:harvest:run data
      dktl drush cron

Add demo site content
---------------------

Generate the same 10 datasets that are used on the demo site.
Enable the sample content module. Run the create command to add the datasets.
Running cron will run the queues that fetch the csv files and import them into datstore tables.
Remove the datasets with the remove command.

.. code-block::

      dktl drush en sample_content -y
      dktl drush dkan:sample-content:create
      dktl drush cron
      dktl drush dkan:sample:content:remove


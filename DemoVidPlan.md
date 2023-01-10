# Demo Video Plan for Cotiss Feedback Project

> Chris Sa

## Table of Contents

- [Demo Video Plan for Cotiss Feedback Project](#demo-video-plan-for-cotiss-feedback-project)
  - [Table of Contents](#table-of-contents)
  - [Restrictions](#restrictions)
  - [Important Points](#important-points)
  - [Outline](#outline)
  - [Situation](#situation)
  - [Task](#task)
  - [Steps Taken](#steps-taken)
  - [Walkthrough - Level 1](#walkthrough---level-1)
    - [Additional notes - Level 1](#additional-notes---level-1)
  - [Walkthrough - Level 2](#walkthrough---level-2)
    - [Additional notes - Level 2](#additional-notes---level-2)
  - [Final thoughts](#final-thoughts)

## Restrictions

- **Max** 10min

## Important Points

- Adding in auto-increment (Don't like the solution. Should look for another way to have unique keys and stay anonyms)
- Added "Rating" to comments to allow for filtering/analyses of the feedback (Additional)
- Having the level 1 EC2 interact with DynamoDB (Difficult)
- Having the EC2 created by Elastic Beanstalk interact with DynamoDB (Difficult)

## Outline

## Situation

Cotiss has asked for an "Honest feedback" form where end users can share anonymous feedback about their interactions with the company.
That could be as an employee or a third party.

## Task

Create a simple webpage that displays a random piece of feedback and allows the user to submit some feedback anonymously.  

This was to be completed using only the Amazon Web Services (AWS) free tier.

## Steps Taken

 1. Talked about our basic outline of what and how we wanted to approach the levels. (Set level 2/3 as our goal)
 2. Tried to follow the provided structure for steps and checkpoints. We found that we completed level one much faster than the outline stated but we got stuck on level two for longer than anticipated.

## Walkthrough - Level 1

1. Create base frontend and backend webpages
   - I decided to use PHP for the backend as it is a simple language and I have used it before
   - I also added a simple "rating" system to go with the feedback. It has the options of "Good", "Bad" and "Neutral". I did this to allow for filtering and easier analysis of the feedback. One potential drawback of this solution is feedback getting ignored due to focusing too much on the rating.
   - When writing the backend PHP script I had to find a way to make unique partition keys for the DynamoDB table. I decided to make an auto-increment system. This is not a good solution as it is slow and not how DynamoDB tables should be made. I would like to find a better solution to this.
2. Create VPC with an internet gateway and route table that includes the default route and the internet gateway
3. Make a table in DynamoDB using `id` as the partition key
4. Make an IAM role that allows DyanmoDB Read/ Write access
5. Launch an EC2 instance. Make sure to include:
   - A security key
   - The VPC created in step 2
   - Enable public IPv4
   - Create or select a Security group that allows SSH and HTTP
   - Attach IAM role from step 4
6. Install both httpd and PHP on the EC2 instance
7. Enable the Apache server to start on boot
8. Transfer accross the frontend pages into
9. Check the page works using the IPv4 address as the URL
10. Stop the EC2 instance
11. Create an AMI
12. Make a launch template using the AMI
    - Be sure to include the IAM role in the template
13. Create an Auto Scaling Group
    - Attach to a new Load Balancer
    - Make it internet facing
    - Select "Create Target Group"
14. Add a DynamoDB endpoint to the VPC
15. Confirm the newly launched EC2 instance can access the DynamoDB table and that the webpage is displaying correctly

### Additional notes - Level 1

- Initially, the EC2 instance couldn't access the DynamoDB table. This was originally fixed by giving the EC2 a public IPv4 address but this solution didn't seem like a good one or the right one. I then found that I could add a DynamoDB endpoint to the VPC and this fixed the issue without the EC2 having a public IP address.

## Walkthrough - Level 2

1. Write a new file called `composer.json` and define the AWS PHP SDK version
2. Zip the composer and webpage files together
3. Create a DynamoDB table with a composite key of `id` or use the one made in level 1
4. Create a new Elastic Beanstalk application
5. Make a new web server environment
    - Select PHP as the platform
    - Upload the zip file
    - Change the proxy server to Apache
    - Change environment type to load balanced
    - This is where you can turn on monitoring of health status
    - Select the VPC made in level 1 and confirm instances will have public IPv4 addresses
6. Find the IAM profile made by the elastic beanstalk and add the restrictive DynamoDB policy to it
7. Confirm the webpage is working correctly
8. Make an S3 bucket and upload some images
9. Include the images on the webpage
10. Zip together the new webpage files with the composer.json file
11. Deploy the new webserver version
12. Request a new SSL certificate in AWS Certificate Manager
    - Add the domain names
      - cotiss.chris-sa.com
      - static.chris-sa.com
    - Wait for the certificate to be issued
13. Create a new distribution in CloudFront
    - Select the Elastic Load Balancer linked to the Elastic Beanstalk as the origin
    - Choose `GET, HEAD, OPTIONS, PUT, POST, PATCH, DELETE` under the HTTP methods
    - Pick `CachingDisabled` under the cache and origin request settings
    - Add an alternate domain name
    - Select the SSL certificate created in step 12
14. Create a behavior in the distribution for all items to redirect HTTP to HTTPS
15. Create another distribution in CloudFront
    - Select the S3 bucket as the origin
    - Add an alternate domain name
    - Select the SSL certificate created in step 12
16. In Route 53, add the two CloudFront distributions as aliases with a record of type A
17. Confirm the webpage is working correctly from the new domain name

### Additional notes - Level 2

- At first, the Elastic Beanstalk could not access the DynamoDB table giving a `Credentials Error`, the same as in level 1.
- It wasn't a VPC or IP address issue though as the endpoint still existed in the VPC and the instances had a public IPv4 address.
- Through research and digging I learned you can supply the composer.json file with the zip file to install the AWS PHP SDK version you want.
- Even after doing this it still gave the same error.
- Spent over a week trying to resolve the issue.
- Turned out I had entered the incorrect SDK version in the composer file.
- After integrating CloudFront the random feedback stopped randomizing. This turned out to be because CloudFront had cached the webpage and was serving the same page to everyone. This was fixed by disabling caching in the CloudFront distribution.

## Final thoughts

That is all. A quick look at two different ways to implement an honest feedback form using AWS. Thank you for watching and I hope you enjoyed it. If you have any questions or suggestions please let me know in the comments or on my [GitHub](https://github.com/JJeeff248/cotiss-project) linked below.

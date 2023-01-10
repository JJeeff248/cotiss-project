# Cotiss Feedback Documentation

> Chris Sa

## Table of Contents

- [Cotiss Feedback Documentation](#cotiss-feedback-documentation)
  - [Table of Contents](#table-of-contents)
  - [Demonstration Video](#demonstration-video)
  - [Documentation](#documentation)

## Demonstration Video

[Link to video]

## Documentation

 1. Create base frontend and backend webpages
    - I decided to use PHP for the backend as it is a simple language and I have used it before
    - I also added in a simple "rating" to go with the feedback. It has the options of "Good", "Bad" and "Neutral". I did this to allow for filtering and easier analysis of the feedback. One potential drawback of this solution is feedback getting ignored due to focussing too much on the rating.
    - When writing the backend php script I had to find a way to make unique partition keys for the DynamoDB table. I decided to make an auto increment system. This is not a good solution as it is slow and not how DynamoDB tables should be made. I would like to find a better solution to this.
 2. Create VPC with an internet gateway and route table that includes the default route and the internet gateway
 3. Make a table in DynamoDB using `id` as the partition key
 4. Make an IAM role that allows DyanmoDB Read/ Write access
 5. Launch an EC2 instance. Make sure to include:
    - A security key
    - The VPC created in step 2
    - Enable public IPv4
    - Create or select a Security group that allows SSH and HTTP
    - Attach IAM role from step 4
 6. SSH into the EC2 instance   `ssh ec2-user@your-ipv4-address`
 7. Update the packages and install both httpd and PHP  `sudo yum update -y && sudo yum install httpd php -y`
 8. Start the Apache webserver  `sudo systemctl start`
 9. Enable the Apache server to start on boot   `sudo systemctl enable httpd`
 10. Transfer accross the frontend pages into `/var/www/html`
 11. Check the page works using the IPv4 address as the URL
 12. Stop the EC2 instance
 13. Create an AMI
 14. Make a launch template using the AMI
    - Be sure to include the IAM role in the template
 15. Create an Auto Scaling Group
    - Attach to a new Load Balancer
    - Make it internet facing
    - Select "Create Target Group"
 16. Add a DynamoDB endpoint to the VPC
 17. Confirm the newly launched instance/s still work (Use load balancer DNS)

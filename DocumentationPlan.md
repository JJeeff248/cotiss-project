# Documentation Plan

> Chris Sa
> Other Information

## Overview

Overview of the product.

## Objectives

Objectives of the product.

## Table of contents

- [Documentation Plan](#documentation-plan)
  - [Overview](#overview)
  - [Objectives](#objectives)
  - [Table of contents](#table-of-contents)
  - [Outline](#outline)
  - [Level one](#level-one)
    - [Setup (Level one)](#setup-level-one)
    - [VPC](#vpc)
    - [DynamoDB](#dynamodb)
    - [EC2](#ec2)
      - [Setup (EC2)](#setup-ec2)
      - [Software](#software)
    - [Auto Scaling Group](#auto-scaling-group)
    - [Clean up (Level one)](#clean-up-level-one)
  - [Level two](#level-two)
    - [Setup (Level two)](#setup-level-two)
    - [Elastic Beanstalk](#elastic-beanstalk)
    - [S3](#s3)
    - [Certificate](#certificate)
    - [CloudFront](#cloudfront)
      - [Website distribution](#website-distribution)
      - [Static content distribution](#static-content-distribution)
    - [Route 53](#route-53)
    - [Redeploy](#redeploy)
    - [Clean up (Level two)](#clean-up-level-two)
  - [Cost estimate](#cost-estimate)
  - [References](#references)

## Outline

Talk about both levels.

## Level one

Objectives of level one.

### Setup (Level one)

Setting up level one.

- PHP files
- IAM role

### VPC

- Correct CIRD for 3 subnets
- IGW
- Route Table
- Make an endpoint for DynamoDB

### DynamoDB

- Make the table with the partition key as ID
- Could suggest changing to base64 as mentioned in the video?
- Could add sort key for ratings.

### EC2

#### Setup (EC2)

- Security Key
- IAM role
- Public IPv4
- Security Group
- VPC

#### Software

- Update packages
- Install PHP and Apache
- Enable Apache on boot
- Move PHP files to `/var/www/html`
- Check it works

### Auto Scaling Group

- Create an AMI
  - Stop the EC2 instance
  - IAM Role > Advanced Details
- Create a launch template
  - Version = Latest
  - Instance type
  - Network settings
- Create Auto Scaling Group
  - Launch template
  - VPC
  - Subnets
  - Load Balancer
    - Internet-facing
    - Target Group
  - Size
- Check it works

### Clean up (Level one)

- Terminate EC2 instance
- Delete AMI
- Delete Auto Scaling Group
- Delete Launch Template
- Delete Load Balancer
- Delete Target Group
- Delete DynamoDB table
- Delete VPC
- Delete IAM role/ policy

## Level two

Objectives of level two.

### Setup (Level two)

- composer.json file
- ZIP file

### Elastic Beanstalk

- Create an application
- Create a web server environment
  - PHP as platform
  - Upload ZIP file
  - Configure environment
    - Software
    - Load Balancer
    - VPC
    - Public IP
    - Remember the IAM role created
    - [//]: # (Add a screenshot of IAM role)
    - NOTE: You can add monitoring and alarms
- Add the policy to the IAM role
- Check it works

### S3

- Create a bucket
- Upload images/ static content
- Update website pages to use images from a static URL

### Certificate

- Create a certificate
- Include both `cotiss` and `static.cotiss`

### CloudFront

#### Website distribution

- Create a distribution
- Origin set to Elastic Beanstalk Load Balancer
- Make sure POST is an allowed method
- Disable cache
- Add an alternate domain name
- Select the certificate
- Add a behavior
  - Path pattern = `*`
  - Redirect HTTP to HTTPS

#### Static content distribution

- Create a distribution
- Origin set to S3 bucket
- Add an alternate domain name
- Select the certificate

### Route 53

- Create a hosted zone
- Add a record WebSite
  - Name = `cotiss`
  - Type = A
  - Alias = Yes
  - Alias Target = CloudFront distribution
- Add a record StaticContent
  - Name = `static.cotiss`
  - Type = A
  - Alias = Yes
  - Alias Target = CloudFront distribution

### Redeploy

- ZIP the updated files
- Upload and deploy to Elastic Beanstalk
- Check it works

### Clean up (Level two)

- Delete Elastic Beanstalk environment
- Delete CloudFront distributions
- Delete S3 bucket (both buckets)
- Delete Route 53 hosted zone or records
- Delete Certificate

## Cost estimate

- Level one vs level two
- How to reduce costs

## References

- DynamoDB endpoint
- Redirecting HTTP to HTTPS
- Project brief?

[//]: # (End of file)

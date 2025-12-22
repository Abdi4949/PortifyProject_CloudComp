pipeline {
    agent any
    
    environment {
	PATH = "/usr/local/bin:${env.PATH}"
        ACR_NAME = 'portifyacr'
        ACR_LOGIN_SERVER = 'portifyacr.azurecr.io'
        IMAGE_NAME = 'portify'
        RESOURCE_GROUP = 'portify-rg'
        WEBAPP_NAME = 'portify-cc'
        ACR_CREDENTIALS = credentials('acr-credentials')
    }
    
    stages {
        stage('Checkout') {
            steps {
                checkout scm
                script {
                    // Get commit SHA for tagging
                    env.GIT_COMMIT_SHORT = sh(
                        script: "git rev-parse --short HEAD",
                        returnStdout: true
                    ).trim()
                    
                    echo "Building commit: ${env.GIT_COMMIT_SHORT}"
                }
            }
        }
        
        stage('Prepare Environment') {
            steps {
                script {
                    echo "Preparing Laravel environment..."
                    sh '''
                        # Create .env file for build (if needed)
                        if [ ! -f .env ]; then
                            cp .env.example .env || echo "No .env.example found"
                        fi
                    '''
                }
            }
        }
        
        stage('Build Docker Image') {
            steps {
                script {
                    echo "Building Docker image for Laravel application..."
                    sh """
                        docker build -t ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:${GIT_COMMIT_SHORT} .
                        docker tag ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:${GIT_COMMIT_SHORT} ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:latest
                    """
                }
            }
        }
        
        stage('Test Image') {
            steps {
                script {
                    echo "Testing Docker image..."
                    sh """
                        # Quick test to ensure image builds correctly
                        docker run --rm --entrypoint php ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:${GIT_COMMIT_SHORT} php -v
                    """
                }
            }
        }
        
        stage('Login to ACR') {
            steps {
                script {
                    echo "Logging in to Azure Container Registry..."
                    sh """
                        echo ${ACR_CREDENTIALS_PSW} | docker login ${ACR_LOGIN_SERVER} -u ${ACR_CREDENTIALS_USR} --password-stdin
                    """
                }
            }
        }
        
        stage('Push to ACR') {
            steps {
                script {
                    echo "Pushing images to ACR..."
                    sh """
                        docker push ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:${GIT_COMMIT_SHORT}
                        docker push ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:latest
                    """
                    echo "✅ Successfully pushed images:"
                    echo "   - ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:${GIT_COMMIT_SHORT}"
                    echo "   - ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:latest"
                }
            }
        }
        
        stage('Deploy to Azure Web App') {
            steps {
                script {
                    echo "Triggering Azure Web App deployment..."
                    
                    sh """
                        # Update container image
                        az webapp config container set \
                            --name ${WEBAPP_NAME} \
                            --resource-group ${RESOURCE_GROUP} \
                            --container-image-name ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:${GIT_COMMIT_SHORT}
                        
                        # Restart web app to pull new image
                        az webapp restart \
                            --name ${WEBAPP_NAME} \
                            --resource-group ${RESOURCE_GROUP}
                    """
                }
            }
        }
        
        stage('Health Check') {
            steps {
                script {
                    echo "Waiting for application to start..."
                    sleep(time: 30, unit: 'SECONDS')
                    
                    sh """
                        echo "Checking application health..."
                        curl -f https://${WEBAPP_NAME}.azurewebsites.net || echo "Health check failed, check logs"
                    """
                }
            }
        }
        
        stage('Cleanup') {
            steps {
                script {
                    echo "Cleaning up local images..."
                    sh """
                        docker rmi ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:${GIT_COMMIT_SHORT} || true
                        docker rmi ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:latest || true
                        docker image prune -f || true
                    """
                }
            }
        }
    }
    
    post {
        success {
            script {
                def duration = currentBuild.durationString.replace(' and counting', '')
                echo """
╔═══════════════════════════════════════════════════════════╗
║           🎉 DEPLOYMENT SUCCESSFUL 🎉                      ║
╠═══════════════════════════════════════════════════════════╣
║ Build: #${env.BUILD_NUMBER}                              ║
║ Commit: ${env.GIT_COMMIT_SHORT}                          ║
║ Duration: ${duration}                                     ║
║                                                           ║
║ 🌐 Application URL:                                       ║
║    https://${WEBAPP_NAME}.azurewebsites.net              ║
║                                                           ║
║ 🐳 Docker Images:                                         ║
║    ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:${env.GIT_COMMIT_SHORT} ║
║    ${ACR_LOGIN_SERVER}/${IMAGE_NAME}:latest              ║
╚═══════════════════════════════════════════════════════════╝
                """
            }
        }
        failure {
            script {
                echo """
╔═══════════════════════════════════════════════════════════╗
║           ❌ DEPLOYMENT FAILED ❌                          ║
╠═══════════════════════════════════════════════════════════╣
║ Build: #${env.BUILD_NUMBER}                              ║
║ Commit: ${env.GIT_COMMIT_SHORT}                          ║
║                                                           ║
║ Please check the console output for error details.       ║
╚═══════════════════════════════════════════════════════════╝
                """
            }
        }
        always {
            sh 'docker logout ${ACR_LOGIN_SERVER} || true'
        }
    }
}

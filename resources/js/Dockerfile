FROM node:14-alpine AS development
ENV NODE_ENV development
# Add a work directory
WORKDIR /home/node/app

# Cache and Install dependencies
COPY yarn.lock .
COPY package.json .
COPY package-lock.json .

RUN npm install

# Copy app files
COPY . .

# Start the app
CMD ["yarn","start" ]

# Expose port
EXPOSE 3000